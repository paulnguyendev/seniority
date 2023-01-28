<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\User\Entities\UserModel as MainModel;
use Illuminate\Support\Facades\Mail;
use Modules\Authen\Emails\SendVerifyEmail;

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
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        return view("{$this->pathViewController}index", []);
    }
    public function trashIndex(Request $request)
    {
        return view("{$this->pathViewController}index", []);
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
        $searchValue = isset($search['value']) ? $search['value'] : "";
        if (!$searchValue) {
            $data = $this->model->listItems(['start' => $start, 'length' => $length], ['task' => 'list']);
        } else {
            $data = $this->model->listItems(['title' => $searchValue], ['task' => 'search']);
        }
        $data = $data->toArray();
        $data = array_map(function ($item) {
            $item['route_edit'] = route('user_admin/form', ['id' => $item['id']]);
            $item['route_verify'] = route('user_admin/sendMailVerify', ['email' => $item['email'], 'token' => $item['token']]);
            $item['route_suppend'] = route('user_admin/suspend', ['id' => $item['id'], 'suspend' => $item['is_suppend']]);
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
    public function trash(Request $request) {
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
}
