<?php

namespace App\Http\Controllers\Staff;

use App\Helpers\Agent;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel;
use App\Models\ApplicationModel as MainModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\Agent\Entities\AgentLicense;

class ApplicationController extends Controller
{
    private $pathViewController     = "staffs.pages.application";
    private $controllerName         = "application";
    private $routeName         = "staffs/application";
    private $model;
    private $agentLicenseModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->agentLicenseModel = new AgentLicenseModel();
        View::share('controllerName', $this->controllerName);
        View::share('routeName', $this->routeName);
        View::share('pathViewController', $this->pathViewController);
    }
    public function index(Request $request)
    {
        $totalAll = $this->model->whereNull('deleted_at')->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->count();
       
        return view(
            "{$this->pathViewController}/index",
            [
                'totalAll' => $totalAll,
                'totalTrash' => $totalTrash,
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
        $module = "Application";
        $title = "Add New {$module}";
        $item = [];
        $agents = $this->agentLicenseModel->listItems([],['task' => 'list']);
       
        if ($id) {
            $item = $this->model::findOrFail($id);
            $title = "Eidt New {$module}";
        }
        return view(
            "{$this->pathViewController}/form",
            [
                'title' => $title,
                'id' => $id,
                'item' => $item,
                'agents' => $agents,
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
            $item['route_edit'] = route("{$this->routeName}/form", ['id' => $item['id']]);
            $item['route_remove'] = route("{$this->routeName}/trash", ['id' => $item['id']]);
            $item['route_delete'] = route("{$this->routeName}/delete", ['id' => $item['id']]);
            $item['route_restore'] = route("{$this->routeName}/updateField", ['id' => $item['id'], 'task' => 'restore']);

            #_data
            $item['fullname'] = "{$item['first_name']} {$item['middle_name']} {$item['last_name']}";
            $item['mobile'] = show_phone($item['mobile']);
            $item['status'] = show_status($item['status']);
            $agentId = $item['agent_id'] ?? "";
            $item['agentInfo'] = Agent::showInfo($agentId);
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
        $first_name = isset($params['first_name']) ? $params['first_name'] : "";
        $last_name = isset($params['last_name']) ? $params['last_name'] : "";
        $email = isset($params['email']) ? $params['email'] : "";
        $agent_id = isset($params['agent_id']) ? $params['agent_id'] : "";
        $mobile = isset($params['mobile']) ? $params['mobile'] : "";
        $mobile = $mobile ? clean($mobile) : "";
        
        if (!$first_name) {
            $error['first_name'] = "Please enter first name";
        }
        if (!$last_name) {
            $error['last_name'] = "Please enter last name";
        }
        if (!$email) {
            $error['email'] = "Please enter email";
        } 
      
        if (!$mobile) {
            $error['mobile'] = "Please enter mobile";
        } else {
            $params['mobile'] = clean($params['mobile']);
        }
        if (!$agent_id) {
            $warning['agent_id'] = "Please choose Ambassador";
        } 
        if (empty($error) && empty($warning)) {
            $params['mobile'] = $mobile;
            $params['code'] = random_code();
            $params['status'] = $params['status'] ? $params['status'] : "open";
            $status = 200;
            if ($id) {
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update Application Success";
            } else {
                $params['token'] = md5($params['email'] . time());
                $msg = "Add Application Success";
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
}
