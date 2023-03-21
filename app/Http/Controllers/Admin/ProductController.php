<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Agent;
use App\Helpers\Level;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel;
use App\Models\ApplicationModel;
use App\Models\ProductModel as MainModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\Agent\Entities\AgentLicense;

class ProductController extends Controller
{
    private $pathViewController     = "staffs.pages.product";
    private $controllerName         = "product";
    private $routeName         = "admin/product";
    private $model;
    private $agentLicenseModel;
    private $applicationModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->agentLicenseModel = new AgentLicenseModel();
        $this->applicationModel = new ApplicationModel();
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
        $module = "Loans";
        $title = "Add New {$module}";
        $item = [];
        $agents = $this->agentLicenseModel->listItems([], ['task' => 'list']);
        $applications = $this->applicationModel->listItems(['status' => 'approve'], ['task' => 'list']);
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
                'applications' => $applications,
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
            $item['total'] = show_price($item['total']) ?? 0;
            $application_id = $item['application_id'] ?? "";
            $applicationInfo  = $application_id ? $this->applicationModel::find($application_id) : [];
            $item['agentInfo'] = Agent::showInfo($agentId);
            $applicationCode = $applicationInfo['code'] ?? "";
            $item['applicationInfo'] = "Application ID: {$applicationCode} <br> <small></small>";
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
        $product_id = null;
        $checkCode = null;
        $application_id = isset($params['application_id']) ? $params['application_id'] : "";
        $agent_id = isset($params['agent_id']) ? $params['agent_id'] : "";
        $total = isset($params['total']) ? $params['total'] : "";
       
        $first_name = isset($params['first_name']) ? $params['first_name'] : "";
        $last_name = isset($params['last_name']) ? $params['last_name'] : "";
        $email = isset($params['email']) ? $params['email'] : "";
        $mobile = isset($params['mobile']) ? $params['mobile'] : "";
        $code = isset($params['code']) ? $params['code'] : "";
        $mobile = $mobile ? clean($mobile) : "";
        $updateLevel = [];
        $checkRank = [];
        $currentRank = [];
        $addLicenseTransaction = [];
        if (!$code) {
            $error['code'] = "Please enter Loans ID";
        } else {
            $checkCode = $this->model->getItem(['code' => $code], ['task' => 'code']);
            if ($checkCode) {
                $error['code'] = "Loans ID already exists";
            }
        }
        if (!$total) {
            $error['total'] = "Please enter Amount";
        }
      
        if (!$application_id) {
            $warning['application_id'] = "Please choose Application Info";
        }
        if (empty($error) && empty($warning)) {
            if ($mobile) {
                $params['mobile'] = $mobile;
            }
            $params['status'] = "active";
            $status = 200;
            #_Update Level
            if ($agent_id) {
                $updateLevel =  Level::updateLevel($agent_id);
            }
            if ($id) {
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update Loans Success";
            } else {
                $msg = "Add Loans Success";
                $product_id = $this->model->saveItem($params, ['task' => 'add-item']);
                $params['redirect'] = route("{$this->routeName}/index");
            }
            $this->applicationModel->saveItem(['id' => $application_id, 'status' => 'closed'], ['task' => 'edit-item']);
            if ($agent_id) {
                #_Add transaction
                $addLicenseTransaction = Level::addLicenseTransaction([
                    'agentId' => $agent_id,
                    'productId' => $product_id,
                    'total' => $total,
                ]);
                $checkRank = $updateLevel['checkLevelInfo'] ?? [];
                if ($checkRank) {
                    $productsOfAgent = Level::getProductsOfAgent($agent_id,$product_id);
                    if (count($productsOfAgent) > 0) {
                        foreach ($productsOfAgent as $product) {
                            $this->model->saveItem(['id' => $product['id'], 'status' => 'complete'], ['task' => 'edit-item']);
                        }
                    }
                }
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
        $params['updateLevel'] = $updateLevel;
        $params['currentRank'] = $currentRank;
        $params['addLicenseTransaction'] = $addLicenseTransaction;
        $params['checkRank'] = $checkRank;
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
    public function application(Request $request)
    {
        $params = $request->all();
        $applicationId = $params['applicationId'] ?? "";
        $application = $this->applicationModel::find($applicationId);
        $application = $application ? $application->toArray() : [];
        $application['mobile'] = isset($application['mobile']) ? show_phone($application['mobile']) : "";
        return $application;
    }
    public function checkLevel(Request $request)
    {
        $agentId = 4;
        $result = Level::checkLevel($agentId);
        return $result;
    }
}
