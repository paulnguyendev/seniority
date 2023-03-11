<?php
namespace App\Http\Controllers\Admin;
use App\Helpers\Agent;
use App\Helpers\Setting;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel ;
use App\Models\AgentNonLicenseModel;
use App\Models\LevelNonLicencedModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Agent\Entities\AgentLicense;
use Modules\Authen\Emails\SendVerifyEmail;
use Modules\LevelLicenced\Entities\ConditionLicenseLevelModel;
use Modules\LevelLicenced\Entities\LevelLicencedModel as MainModel;
class MortgageRankingController extends Controller
{
    private $pathViewController     = "staffs.pages.mortgage_ranking";
    private $controllerName         = "mortgage_ranking";
    private $routeName         = "admin/mortgage_ranking";
    private $model;
    private $conditionLicenceModel;
    private $agentLicenseModel;
    private $agentNonLicenseModel;
    private $levelLicenseModel;
    private $levelNonLicenseModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->levelNonLicenseModel = new LevelNonLicencedModel();
        $this->agentNonLicenseModel = new AgentNonLicenseModel();
        $this->conditionLicenceModel = new ConditionLicenseLevelModel();
        View::share('controllerName', $this->controllerName);
        View::share('routeName', $this->routeName);
        View::share('pathViewController', $this->pathViewController);
    }
    public function index(Request $request)
    {
        $totalAll = $this->model->whereNull('deleted_at')->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->count();
        $licenses = $this->levelLicenseModel->listItems([],['task' => 'list']);
        $nonLicenses = $this->levelNonLicenseModel->listItems([],['task' => 'list']);
        $routeNonLicense = "staffs/community";
        $routeLicense = "staffs/mortgage";
        return view(
            "{$this->pathViewController}/index",
            [
                'totalAll' => $totalAll,
                'totalTrash' => $totalTrash,
                'licenses' => $licenses,
                'routeNonLicense' => $routeNonLicense,
                'nonLicenses' => $nonLicenses,
                'routeLicense' => $routeLicense,
            ]
        );
    }
    public function trashIndex(Request $request)
    {
        $totalAll = 0;
        $totalTrash = 0;
        return view("{$this->pathViewController}/trash", [
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
        ]);
    }
    public function form(Request $request)
    {
        $id = $request->id;
        $rankings = $this->model->listItems([],['task' => 'list']);
        $module = "Mortgage Ranking";
        $title = "Add New {$module}";
        $item = [];
        $itemCondition = [];
        if ($id) {
            $rankings = $this->model->listItems(['not_id' => $id],['task' => 'list']);
            $item = $this->model::findOrFail($id);
            $itemCondition = $item->conditionLevel()->first();
            $title = "Edit {$module}";
        }
        return view(
            "{$this->pathViewController}/form",
            [
                'title' => $title,
                'id' => $id,
                'item' => $item,
                'rankings' => $rankings,
                'itemCondition' => $itemCondition,
            ]
        );
    }
    public function data(Request $request)
    {
        $data = [];
        $params = $request->all();
        $draw = isset($params['draw']) ? $params['draw'] : "";
        $start = isset($params['start']) ? $params['start'] : "";
        $length = isset($params['length']) ? $params['length'] : "";
        $search = isset($params['search']) ? $params['search'] : "";
        $status = isset($params['status']) ? $params['status'] : "";
        $parent_id = isset($params['parent_id']) ? $params['parent_id'] : "";
        $is_trash = $request->is_trash ?? 0;
        $searchValue = isset($search['value']) ? $search['value'] : "";
        $paramsData['status'] = $status;
        $paramsData['is_trash'] = $is_trash;
        $paramsData['parent_id'] = $parent_id;
        if (!$searchValue) {
            $paramsData['start'] = $start;
            $paramsData['length'] = $length;
            $data = $this->model->listItems($paramsData, ['task' => 'list']);
        } else {
            $data = $this->model->listItems(['title' => $searchValue, 'is_trash' => $is_trash], ['task' => 'search']);
        }
        $data = $data->toArray();
        $data = array_map(function ($item) {
            $id = $item['id'];
            #_Route
            $verify_code = $item['verify_code'] ?? "";
            $item['route_edit'] = route("{$this->routeName}/form", ['id' => $item['id']]);
            $item['route_verify'] = route("{$this->routeName}/sendMailVerify", ['email' => $item['email'], 'token' => $item['token'], 'verify_code' => $verify_code]);
            $item['route_suppend'] = route("{$this->routeName}/suspend", ['id' => $item['id'], 'suspend' => $item['is_suppend']]);
            $item['route_restore'] = route("{$this->routeName}/updateField", ['id' => $item['id'], 'task' => 'restore']);
            $item['route_quickLogin'] = route("auth_agent/quickLogin", ['token' => $item['token']]);
            $item['route_remove'] = route("{$this->routeName}/trash", ['id' => $item['id']]);
            $item['route_delete'] = route("{$this->routeName}/delete", ['id' => $item['id']]);
            $parent_id = $item['parent_id'];
            $item['user_info'] = Agent::showInfo($id);
            $item['sponsor_info'] = $parent_id ?  Agent::showInfo($parent_id) : "";
            $item['status'] = show_status($item['status']);
            $thumbnail = $item['thumbnail'] ?? get_default_thumbnail_url();
            $item['thumbnail'] = get_thumbnail_url($thumbnail);
            $item['created_at'] = date('H:i:s d-m-Y', strtotime($item['created_at']));
            return $item;
        }, $data);
        $result = [
            "draw" => 0,
            "recordsTotal" => $this->model->count(),
            "recordsFiltered" => $this->model->count(),
            "data" => $data
        ];
        return $result;
    }
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $request->id;
        $error = [];
        $warning = [];
        $curentEmail = null;
        $curentMobile = null;
        $curentUsername = null;
        $curentPassword = null;
        $curentCode = null;
        $name = isset($params['name']) ? $params['name'] : "";
        $personal_payout = isset($params['personal_payout']) ? $params['personal_payout'] : "";
        $team_overrides = isset($params['team_overrides']) ? $params['team_overrides'] : "";
        $condition_license_levels = isset($params['condition_license_levels']) ? $params['condition_license_levels'] : [];
        $condition_id = isset($params['condition_id']) ? $params['condition_id'] : "";
        if (!$name) {
            $error['name'] = "Please enter ranking name";
        }
        if (!$personal_payout) {
            $error['personal_payout'] = "Please enter personal payout";
        }
        if ($team_overrides == '') {
            $error['team_overrides'] = "Please enter team overrides";
        }
        if (empty($error) && empty($warning)) {
            $status = 200;
            if ($id) {
                if($condition_id) {
                    $condition_license_levels['id'] = $condition_id;
                    $this->conditionLicenceModel->saveItem($condition_license_levels,['task' => 'edit-item']);
                }
                else {
                    $condition_license_levels['level_id'] = $id;
                    $this->conditionLicenceModel->saveItem($condition_license_levels,['task' => 'add-item']);
                }
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update ranking Success";
            } else {
                $msg = "Add ranking Success";
                $this->model->saveItem($params, ['task' => 'add-item']);
                $params['redirect'] = route("{$this->routeName}/index");
            }
        } elseif (!empty($warning) && empty($error)) {
            $status = 500;
            $msg = array_shift($warning);
        } else {
            $status  = 400;
            $msg = $error;
        }
        $params['msg'] = $msg;
        $params['error'] = $error;
        $params['warning'] = $warning;
        $params['status'] = $status;
        return $params;
    }
    public function updateField(Request $request)
    {
        $id = $request->id;
        $task = $request->task;
        $msg = null;
        if ($task == 'restore') {
            $this->model->saveItem(['id' => $id, 'deleted_at' => NULL], ['task' => 'edit-item']);
            $msg = "Item restore success";
        }
        return [
            'success' => true,
            'message' => $msg,
        ];
    }
    public function trash(Request $request)
    {
        $id = $request->id;
        $this->model->saveItem(['id' => $id, 'deleted_at' => date('Y-m-d H:i:s')], ['task' => 'edit-item']);
        return [
            'success' => true,
            'message' => 'Content moved to trash'
        ];
    }
    public function delete(Request $request)
    {
        $id = $request->id;
        $this->model->deleteItem(['id' => $id], ['task' => 'delete']);
        $this->model::fixTree();
        return [
            'success' => true,
            'message' => 'Đã chuyển nội dung vào thùng rác'
        ];
    }
    public function trashDestroy(Request $request)
    {
        $ids = $request->ids;
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $this->model->saveItem(['id' => $id, 'deleted_at' => date('Y-m-d H:i:s')], ['task' => 'edit-item']);
            }
        }
        return $ids;
    }
    public function destroy(Request $request)
    {
        $ids = $request->ids;
        if (count($ids) > 0) {
            foreach ($ids as $id) {
                $this->model->deleteItem(['id' => $id], ['task' => 'delete']);
            }
        }
        return $ids;
    }
    public function suspend(Request $request)
    {
        $id = $request->id;
        $suspend = $request->suspend;
        $verify_code = $request->verify_code;
        $suspend = $suspend == '1' ? "0" : "1";
        $msg = $suspend == '1' ? "Suspended" : "UnSuspended";
        $this->model->saveItem(['id' => $id, 'is_suppend' => $suspend], ['task' => 'edit-item']);
        return [
            'success' => true,
            'message' => "{$msg} user successfully"
        ];
    }
    public function sendMailVerify(Request $request)
    {
        $email = $request->email;
        $token = $request->token;
        $verify_code = $request->verify_code;
        $params['email'] = $email;
        $params['token'] = $token;
        $params['verify_code'] = $verify_code;
        Mail::to($params['email'])->send(new SendVerifyEmail($params));
        return [
            'success' => true,
            'message' => "Send mail verify this user successfully"
        ];
    }
    public function setting(Request $request) {
        $params = $request->all();
        $meta_key = $params['meta_key'] ?? "";
        $meta_value = $params['meta_value'] ?? "";
        Setting::updateValue($meta_key,$meta_value);
        return $params;
    }
}
