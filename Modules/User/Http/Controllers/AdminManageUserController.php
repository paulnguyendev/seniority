<?php
namespace Modules\User\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\User\Entities\UserModel as MainModel;
use Illuminate\Support\Facades\Mail;
use Modules\Authen\Emails\SendVerifyEmail;
use Modules\MLM\Entities\MlmLevelModel;
use Modules\MLM\Entities\MlmTypeModel;
class AdminManageUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "user::pages.admin.";
    private $controllerName         = "user_admin";
    private $moduleName         = "user";
    private $model;
    private $mlmTypeModel;
    private $mlmlLevelModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        if(class_exists('Modules\MLM\Entities\MlmTypeModel')) {
            $this->mlmTypeModel = new MlmTypeModel();
        }
        if(class_exists('Modules\MLM\Entities\MlmLevelModel')) {
            $this->mlmlLevelModel = new MlmLevelModel();
        }
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        $totalAll = $this->model->whereNull('deleted_at')->where('type','user')->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->where('type','user')->count();
        return view("{$this->pathViewController}index", [
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
        ]);
    }
    public function trashIndex(Request $request)
    {
        $totalAll = $this->model->whereNull('deleted_at')->where('type','user')->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->where('type','user')->count();
        return view("{$this->pathViewController}trash", [
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
        ]);
    }
    public function profile(Request $request)
    {
        return view("{$this->pathViewController}profile", []);
    }
    public function profileSave(Request $request)
    {
        $params = $request->all();
        $error = [];
        if (!$params['first_name']) {
            $error['first_name'] = "Please enter first name";
        }
        if (!$params['last_name']) {
            $error['last_name'] = "Please enter last name";
        }
        if (!$params['email']) {
            $error['email'] = "Please enter email";
        }
        if (!$params['phone']) {
            $error['phone'] = "Please enter Phone";
        }
        if (empty($error)) {
            $status = 200;
            $this->model->saveItem($params, ['task' => 'edit-item']);
            $msg = "Update Profile Success";
        } else {
            $status  = 400;
            $msg = $error;
        }
        $params['msg'] = $msg;
        $params['status'] = $status;
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
        $is_trash = $request->is_trash ?? 0;
        
        $searchValue = isset($search['value']) ? $search['value'] : "";
        if (!$searchValue) {
            $data = $this->model->listItems(['start' => $start, 'length' => $length,'type' => 'user','is_trash' => $is_trash], ['task' => 'list']);
        } else {
            $data = $this->model->listItems(['title' => $searchValue, 'type' => 'user', 'is_trash' => $is_trash], ['task' => 'search']);
        }
        $data = $data->toArray();
        $data = array_map(function ($item) {
            $item['route_edit'] = route('user_admin/form', ['id' => $item['id']]);
            $item['route_verify'] = route('user_admin/sendMailVerify', ['email' => $item['email'], 'token' => $item['token']]);
            $item['route_suppend'] = route('user_admin/suspend', ['id' => $item['id'], 'suspend' => $item['is_suppend']]);
            $item['route_restore'] = route("{$this->controllerName}/updateField", ['id' => $item['id'],'task' => 'restore']);
            $item['user_info'] = sprintf('
            Kevin Heal <br>
            <small>ID: SM343041 - <span class="badge badge-boxed  badge-soft-warning">Non-Licensed</span></small><br>
            <small>Email: tmarkel55@gmail.com</small><br>
            <small>Phone: (949) 697-9753</small> <br>');
            $item['sponsor_info'] = sprintf('
            Bao Ngoc Nguyen <br>
            <small>ID: SM8888 - <span class="badge badge-boxed  badge-soft-primary">Licensed</span></small><br>
            <small>Email: baongocnguyen@yahoo.com</small> <br>
            <small>Phone: (949) 697-9753</small> <br>');
            $item['status'] = show_status($item['status']);
            $item['thumbnail'] = get_thumbnail_url($item['thumbnail']);
            $item['route_remove'] = route('user_admin/trash', ['id' => $item['id']]);
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
    public function updateField(Request $request) {
        $id = $request->id;
        $task = $request->task;
        $msg = null;
        if($task == 'restore') {
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
    public function suspend(Request $request)
    {
        $id = $request->id;
        $suspend = $request->suspend;
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
        $params['email'] = $email;
        $params['token'] = $token;
        Mail::to($params['email'])->send(new SendVerifyEmail($params));
        return [
            'success' => true,
            'message' => "Send mail verify this user successfully"
        ];
    }
    public function form(Request $request)
    {
        $id = $request->id;
        $title = "Add item";
        $item = [];
        $users = $this->model->listItems(['type' => 'user'], ['task' => 'list']);
        $mlmTypes = $this->mlmTypeModel->listItems([],['task' => 'list']);
        if ($id) {
            $title = "Edit item";
            $item = $this->model::findOrFail($id);
            $users = $this->model->listItems(['type' => 'user','not_id' => $id], ['task' => 'list']);
        }
        return view("{$this->pathViewController}form", [
            'id' => $id,
            'title' => $title,
            'item' => $item,
            'users' => $users,
            'mlmTypes' => $mlmTypes,
            'mlmlLevelModel' => $this->mlmlLevelModel,
        ]);
    }
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $request->id;
        $error = [];
        if (!$params['first_name']) {
            $error['first_name'] = "Please enter first name";
        }
        if (!$params['last_name']) {
            $error['last_name'] = "Please enter last name";
        }
        if (!$params['email']) {
            $error['email'] = "Please enter email";
        }
        if (!$params['phone']) {
            $error['phone'] = "Please enter mobile";
        }
        if (!$params['username']) {
            $error['username'] = "Please enter username";
        }
        if (!$params['password']) {
            $error['password'] = "Please enter password";
        }
        if (!$params['code']) {
            $error['code'] = "Please enter User ID";
        }
        if (!$params['mlm_type_id']) {
            $error['mlm_type_id'] = "Please choose MLM Type";
        }
        if (isset($params['mlm_level_id'] ) && !$params['mlm_level_id']) {
            $error['mlm_level_id'] = "Please choose MLM Level";
        }
        if (!$params['status']) {
            $error['status'] = "Please choose Status";
        }
        if (empty($error)) {
            $params['parent_id'] = isset($params['parent_id']) ? $params['parent_id'] : "";
            $params['password'] = isset($params['password']) ? md5($params['password']) : "";
            $params['token'] = md5($params['email'] . time());
            $params['thumbnail'] = get_default_thumbnail_url();
            $status = 200;
            if($id) {
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update User Success";
            }
            else {
                $msg = "Add User Success";
                $this->model->saveItem($params, ['task' => 'add-item']);
                $params['redirect'] = route("{$this->controllerName}/index");
            }
        } else {
            $status  = 400;
            $msg = $error;
        }
        $params['msg'] = $msg;
        $params['status'] = $status;
        return $params;
    }
}
