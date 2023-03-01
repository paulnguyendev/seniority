<?php

namespace Modules\Product\Http\Controllers;

use App\Helpers\Level;
use App\Helpers\UserHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\Agent\Entities\AgentModel as MainModel;
use Illuminate\Support\Facades\Mail;
use Modules\Agent\Entities\AgentModel;
use Modules\LevelLicenced\Entities\LevelLicencedModel;
use Modules\Authen\Emails\SendVerifyEmail;
use Modules\LevelLicenced\Entities\ConditionLicenseLevelModel;

class ProductStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "product::pages.staff.";
    private $controllerName         = "product_staff";
    private $moduleName         = "product";
    private $model;
    private $levelLicenseModel;
    private $conditionLevelLicenseModel;
    private $agentModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->levelLicenseModel = new LevelLicencedModel();
        $this->conditionLevelLicenseModel = new ConditionLicenseLevelModel();
        $this->agentModel = new AgentModel();
        View::share('controllerName', $this->controllerName);
        View::share('pathViewController', $this->pathViewController);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        $totalAll = $this->model->where('is_root', '0')->whereNull('deleted_at')->count();
        $totalTrash = $this->model->where('is_root', '0')->whereNotNull('deleted_at')->count();
        $agents = $this->model->listItems([], ['task' => 'all']);
        return view("{$this->pathViewController}index", [
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
            'agents' => $agents,
        ]);
    }
    public function form(Request $request)
    {
        $id = $request->id;
        $title = $id ? "Edit Item" : "Add Item";
        $item = [];
        $item = ($id) ? $this->model::findOrFail($id) : [];
        $agents = ($id) ? $this->model->listItems(['not_id' => $id], ['task' => 'all']) : $this->model->listItems([], ['task' => 'all']);
        return view("{$this->pathViewController}form", [
            'title' => $title,
            'item' => $item,
            'id' => $id,
            'agents' => $agents,
        ]);
    }
    public function trashIndex(Request $request)
    {
        $slug = $request->slug;
        $totalAll = 0;
        $totalTrash = 0;
        $agents = $this->model->listItems([], ['task' => 'all']);
        return view("{$this->pathViewController}trash", [
            'slug' => $slug,
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
            'agents' => $agents,
        ]);
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
        $parent_id = isset($params['parent_id']) ? $params['parent_id'] : "";
        $first_name = isset($params['first_name']) ? $params['first_name'] : "";
        $last_name = isset($params['last_name']) ? $params['last_name'] : "";
        $email = isset($params['email']) ? $params['email'] : "";
        $mobile = isset($params['mobile']) ? $params['mobile'] : "";
        $mobile = $mobile ? clean($mobile) : "";
        $username = isset($params['username']) ? $params['username'] : "";
        $password = isset($params['password']) ? $params['password'] : "";
        $code = isset($params['code']) ? $params['code'] : "";
        $status = isset($params['status']) ? $params['status'] : "";
        $type = isset($params['type']) ? $params['type'] : "";
        if (!$first_name) {
            $error['first_name'] = "Please enter first name";
        }
        if (!$last_name) {
            $error['last_name'] = "Please enter last name";
        }
        if (!$email) {
            $error['email'] = "Please enter email";
        } else {
        }
        if (!$mobile) {
            $error['mobile'] = "Please enter mobile";
        } else {
            $params['mobile'] = clean($params['mobile']);
        }
        if (!$username) {
            $error['username'] = "Please enter username";
        }
        if (!$password) {
            $error['password'] = "Please enter password";
        }
        if (!$code) {
            $error['code'] = "Please enter User ID";
        }
        if (!$status) {
            $error['status'] = "Please choose Status";
        }
        if (!$type) {
            $error['type'] = "Please enter Agent Type";
        }
        if (empty($error)) {
            $checkMail = $this->model->getItem(['email' => $email], ['task' => 'email']);
            $checkMobile = $this->model->getItem(['mobile' => $mobile], ['task' => 'mobile']);
            $checkUsername = $this->model->getItem(['username' => $username], ['task' => 'username']);
            $checkCode = $this->model->getItem(['code' => $code], ['task' => 'code']);
            if ($id) {
                $item = $this->model::find($id);
                $curentEmail = $item['email'] ?? "";
                $curentMobile = $item['mobile'] ?? "";
                $curentUsername = $item['username'] ?? "";
                $curentPassword = $item['password'] ?? "";
                $curentCode = $item['code'] ?? "";
                if (($email != $curentEmail) && $checkMail) {
                    $error['email'] = "Email already exists";
                }
                if (($mobile != $curentMobile) && $checkMobile) {
                    $error['mobile'] = "Mobile already exists";
                }
                if (($username != $curentUsername) && $checkUsername) {
                    $error['username'] = "Username already exists";
                }
                if (($code != $curentCode) && $checkCode) {
                    $error['code'] = "Agent ID already exists";
                }
                // if($password != $curentPassword) {
                //     $params['password'] = $password;
                // }
            } else {
                if ($email && $checkMail) {
                    $error['email'] = "Email already exists";
                }
                if ($mobile && $checkMobile) {
                    $error['mobile'] = "Mobile already exists";
                }
                if ($username && $checkUsername) {
                    $error['username'] = "Username already exists";
                }
            }
        }
        if (!$parent_id) {
            $warning['parent_id'] = "Please Choose Sponsor";
        }
        if (empty($error) && empty($warning)) {
            $params['mobile'] = $mobile;
            $params['parent_id'] = $parent_id;
            $params['thumbnail'] = get_default_thumbnail_url();
            $status = 200;
            if ($id) {
                if ($curentPassword != $password) {
                    $params['password'] = md5($password);
                }
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update Agent Success";
            } else {
                $params['token'] = md5($params['email'] . time());
                $params['password'] = md5($password);
                $msg = "Add Agent Success";
                $this->model->saveItem($params, ['task' => 'add-item']);
                $params['redirect'] = route("{$this->controllerName}/index");
            }
        } elseif (!empty($warning) && empty($error)) {
            $status = 500;
            $msg = array_shift($warning);
        } else {
            $status  = 400;
            $msg = $error;
        }
        $params['msg'] = $msg;
        $params['status'] = $status;
        $params['error'] = $error;
        $params['warning'] = $warning;
        $params['curentPassword'] = $curentPassword;
        return $params;
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
            $item['route_edit'] = route("{$this->controllerName}/form", ['id' => $item['id']]);
            $item['route_verify'] = route("{$this->controllerName}/sendMailVerify", ['email' => $item['email'], 'token' => $item['token'], 'verify_code' => $verify_code]);
            $item['route_suppend'] = route("{$this->controllerName}/suspend", ['id' => $item['id'], 'suspend' => $item['is_suppend']]);
            $item['route_restore'] = route("{$this->controllerName}/updateField", ['id' => $item['id'], 'task' => 'restore']);
            $item['route_quickLogin'] = route("auth_agent/quickLogin", ['token' => $item['token']]);
            $item['route_remove'] = route("{$this->controllerName}/trash", ['id' => $item['id']]);
            $item['route_delete'] = route("{$this->controllerName}/delete", ['id' => $item['id']]);
            $parent_id = $item['parent_id'];
            $item['user_info'] = UserHelper::showAgentInfo($id);
            $item['sponsor_info'] = $parent_id ?  UserHelper::showAgentInfo($parent_id) : "";
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
    // Other
    // Other
    public function checkLevel(Request $request)
    {
        $agentId = 7;
        $test = Level::updateLevel($agentId);
        die();
        #License Levels
        $linceseLevels = Level::getLicenseLevels();
        #Childs of Agent
        $childsOfAgent = Level::getChildsOfAgent($agentId);
        # Level ids of childs
        $levelIdsOfChilds = [];
        $levelIdsOfChilds = array_column($childsOfAgent, 'license_level_id');
        $levelIdsOfChilds = array_count_values($levelIdsOfChilds);
        #Products status active of Agent
        $agent = $this->agentModel::find($agentId);
        $numberProductOfAgent = $agent->products()->where('status', 'active')->count();
        $result = [];
        #Number of level
        $numbersOfLevels = [];
        foreach ($linceseLevels as $key => $item) {
            $levelId = $item['id'];
            $levelName = $item['name'] ?? "";
            $numberAgentOfLevel = isset($levelIdsOfChilds[$levelId]) ? $levelIdsOfChilds[$levelId] : 0;
            $numbersOfLevels[$key]['level_id'] = $levelId;
            $numbersOfLevels[$key]['number_agent'] = $numberAgentOfLevel;
            $numbersOfLevels[$key]['number_product'] = $numberProductOfAgent;
            $numbersOfLevels[$key]['level_name'] = $levelName;
        }
        $check = [];
        foreach ($linceseLevels as $item) {
            $levelId = $item['id'];
            $levelName = $item['name'];
            $is_break = $item['is_break'];
            $condition_level = $item['condition_level'] ?? [];
            $number_agent = $condition_level['number_agent'] ?? 0;
            $number_product = $condition_level['number_product'] ?? 0;
            $direct_level_id = $condition_level['direct_level_id'] ?? null;
            // Check Level
            foreach ($numbersOfLevels as $itemNumber) {
                if ($itemNumber['level_id'] == $direct_level_id && $itemNumber['number_agent'] >= $number_agent && $itemNumber['number_product'] >= $number_product) {
                    $itemNumber['check_level_id'] = $levelId;
                    $itemNumber['check_level_name'] = $levelName;
                    $itemNumber['check_is_break'] = $is_break;
                    $check[] = $itemNumber;
                }
            }
        }
        $check = end($check);
        return $check;
        $currentLevel = $this->levelLicenseModel::find($agent['license_level_id'])->name;
        $checkLevelName = $check ? $check['check_level_name'] : $currentLevel;
        $is_break = $check['check_is_break'];
        $is_break_show = $is_break == 1 ? " - Break Away" : "";
        // echo '<pre>';
        // print_r($linceseLevels);
        // echo '</pre>';
        echo "<h1>Number product: {$numberProductOfAgent}</h1>";
        echo "<h1>Number Agent in List Level:</h1>";
        foreach ($result as $item) {
            echo "<li>{$item['level_name']} : {$item['number_agent']}</li>";
        }
        echo "<h1>Check Level: {$checkLevelName} {$is_break_show}</h1>";
    }
}
