<?php
namespace App\Http\Controllers\Admin;
use App\Helpers\Agent;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel as MainModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Agent\Entities\AgentLicense;
use Modules\Authen\Emails\SendVerifyEmail;
use Modules\LevelLicenced\Entities\LevelLicencedModel;

class MortgageAmbassadorController extends Controller
{
    private $pathViewController     = "staffs.pages.mortgage";
    private $controllerName         = "mortgage";
    private $routeName         = "admin/mortgage";
    private $model;
    private $agentLicenseModel;
    private $levelLicenseModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->levelLicenseModel = new LevelLicencedModel();
        View::share('controllerName', $this->controllerName);
        View::share('routeName', $this->routeName);
        View::share('pathViewController', $this->pathViewController);
    }
    public function index(Request $request)
    {
        $totalAll = $this->model->whereNull('deleted_at')->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->count();
        $agents = $this->model->listItems(['has_root' => '1'],['task' => 'list']);
        return view(
            "{$this->pathViewController}/index",
            [
                'totalAll' => $totalAll,
                'totalTrash' => $totalTrash,
                'agents' => $agents,
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
        $module = "Mortgage Ambassador";
        $title = "Add New {$module}";
        $item = [];
        $agents = $this->model->listItems(['has_root' => '1'],['task' => 'list']);
        $levels = $this->levelLicenseModel->listItems([],['task' => 'list']);
       
        if ($id) {
            $item = $this->model::findOrFail($id);
            $title = "Edit {$module}";
            $agents = $this->model->listItems(['not_id' => $id,'has_root' => '1'],['task' => 'list']);
        }
        return view(
            "{$this->pathViewController}/form",
            [
                'title' => $title,
                'id' => $id,
                'item' => $item,
                'agents' => $agents,
                'levels' => $levels,
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
            $item['route_quickLogin'] = "#";
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
        $parent_id = isset($params['parent_id']) ? $params['parent_id'] : "";
        $level_id = isset($params['level_id']) ? $params['level_id'] : "";
        $first_name = isset($params['first_name']) ? $params['first_name'] : "";
        $last_name = isset($params['last_name']) ? $params['last_name'] : "";
        $email = isset($params['email']) ? $params['email'] : "";
        $mobile = isset($params['mobile']) ? $params['mobile'] : "";
        $mobile = $mobile ? clean($mobile) : "";
        $username = isset($params['username']) ? $params['username'] : "";
        $password = isset($params['password']) ? $params['password'] : "";
        $code = isset($params['code']) ? $params['code'] : "";
        $status = isset($params['status']) ? $params['status'] : "";
       
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
        if (!$level_id) {
            $error['level_id'] = "Please choose Level";
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
            $params['verify_code'] = random_verify_code();
            $status = 200;
            if ($id) {
                if ($curentPassword != $password) {
                    $params['password'] = md5($password);
                }
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update Ambassador Success";
            } else {
                $params['token'] = md5($params['email'] . time());
                $params['password'] = md5($password);
                $msg = "Add Agent Success";
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
        $params['status'] = $status;
        $params['error'] = $error;
        $params['warning'] = $warning;
        $params['curentPassword'] = $curentPassword;
        return $params;
    }
    public function updateField(Request $request)
    {
        $id = $request->id;
        $task = $request->task;
        $msg = null;
        if ($task == 'restore') {
            $this->model->saveItem(['id' => $id, 'status' => "active"], ['task' => 'edit-item']);
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
        $status = "trash";
        $this->model->saveItem(['id' => $id, 'status' => $status], ['task' => 'edit-item']);
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
        $status = $suspend == '1' ? "suspended" : "active";
        $this->model->saveItem(['id' => $id, 'is_suppend' => $suspend,'status' => $status], ['task' => 'edit-item']);
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
    public function showData(Request $request) {
        $params = $request->all();
        $column = $params['column'] ?? "";
        $value = $params['value'] ?? "";
        $type = $params['type'] ?? "";
        $items = [];
        if($type) {
            if($type == 'search' && !empty($value)) {
                $items = $this->model->listItems(['title' => $value],['task' => 'search']);
            }
            else {
                $items = $this->model->listItems([],['task' => 'list']);
            }
        }
        else {
            if($column && $value) {
                $items = $this->model->listItems([$column => $value],['task' => 'list']);
            }
            else {
                $items = $this->model->listItems([],['task' => 'list']);
            }
        }
        
        
        $xthml =  view("staffs.pages.ambassadors.license")->with('items', $items)->render();
        $params['items'] = $items;
        $params['xthml'] = $xthml;
        return $params;
    }
}
