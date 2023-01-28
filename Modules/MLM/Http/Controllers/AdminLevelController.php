<?php
namespace Modules\MLM\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\MLM\Entities\MlmLevelModel as MainModel;
use Illuminate\Support\Facades\Mail;
use Modules\Authen\Emails\SendVerifyEmail;

use Modules\MLM\Entities\MlmTypeModel;
class AdminLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "mlm::pages.admin.level.";
    private $controllerName         = "mlm_admin_level";
    private $moduleName         = "mlm";
    private $model;
    private $mlmLevelModel;
    private $mlmTypeModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->mlmTypeModel = new MlmTypeModel();
       
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        $slug = $request->slug;
      
        $mlmType = $this->mlmTypeModel->getItem(['slug' => $slug],['task' => 'slug']);
        $mlm_type_id = $mlmType['id'];
        $totalAll = $this->model->whereNull('deleted_at')->where('mlm_type_id', $mlm_type_id)->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->where('mlm_type_id', $mlm_type_id)->count();
        
        return view("{$this->pathViewController}index", [
            'slug' => $slug,
            'mlmType' => $mlmType,
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
        ]);
    }
    public function form(Request $request)
    {
        $id = $request->id;
        $title = $id ? "Edit Item" : "Add Item";
        $slug = $request->slug;
        $mlmType = $this->mlmTypeModel->getItem(['slug' => $slug],['task' => 'slug']);
        return view("{$this->pathViewController}form", [
            'title' => $title,
            'slug' => $slug,
            'mlmType' => $mlmType,
        ]);
    }
    public function trashIndex(Request $request)
    {
        $slug = $request->slug;
      
        $mlmType = $this->mlmTypeModel->getItem(['slug' => $slug],['task' => 'slug']);
        $mlm_type_id = $mlmType['id'];
        $totalAll = $this->model->whereNull('deleted_at')->where('mlm_type_id', $mlm_type_id)->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->where('mlm_type_id', $mlm_type_id)->count();
        
        return view("{$this->pathViewController}trash", [
            'slug' => $slug,
            'mlmType' => $mlmType,
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
        ]);
    }
    public function save(Request $request)
    {
        $params = $request->all();
        $id = $request->id;
        $error = [];
        if (!$params['name']) {
            $error['name'] = "Please enter name";
        }
        if (empty($error)) {
            $status = 200;
            if($id) {
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update MLM Success";
            }
            else {
                $this->model->saveItem($params, ['task' => 'add-item']);
                $msg = "Add MLM Success";
            }
        } else {
            $status  = 400;
            $msg = $error;
        }
        $params['msg'] = $msg;
        $params['status'] = $status;
        return $params;
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
  
    public function data(Request $request)
    {
        $data = [];
        $params = $request->all();
        $type_id = isset($params['type_id']) ? $params['type_id'] : "";
        $is_trash = isset($params['is_trash']) ? $params['is_trash'] : "0";
        $draw = isset($params['draw']) ? $params['draw'] : "";
        $start = isset($params['start']) ? $params['start'] : "";
        $length = isset($params['length']) ? $params['length'] : "";
        $search = isset($params['search']) ? $params['search'] : "";
        $searchValue = isset($search['value']) ? $search['value'] : "";
        $paramsData['is_trash'] = $is_trash;
        $paramsData['mlm_type_id'] = $type_id;
        if (!$searchValue) {
            $paramsData['start'] = $start;
            $paramsData['length'] = $length;
           
            $data = $this->model->listItems($paramsData, ['task' => 'list']);
        } else {
            $paramsData['title'] = $searchValue;
            $data = $this->model->listItems($paramsData, ['task' => 'search']);
        }
        $data = $data->toArray();
        $recordsFiltered = $this->model->where('mlm_type_id', $type_id)->count();
        $data = array_map(function ($item) {
            $item['route_edit'] = route("{$this->controllerName}/form", ['id' => $item['id']]);
            $item['route_remove'] = route("{$this->controllerName}/trash", ['id' => $item['id']]);
            $item['route_delete'] = route("{$this->controllerName}/delete", ['id' => $item['id']]);
            $item['route_restore'] = route("{$this->controllerName}/updateField", ['id' => $item['id'],'task' => 'restore']);
            $childId = $item['child_id'] ?? 0;
            $child = $this->model::find($childId);
            $childName = $child['name'] ?? "";
            $number_child = $item['number_child'] ?? "0";
            $childInfo = $childName ?  "{$number_child} {$childName}" : "";
            $mlm_type_id = $item['mlm_type_id'];
            $mlmType = $this->mlmTypeModel::find($mlm_type_id);
            $mlm_type_slug = $mlmType['slug'] ?? "";
            $item['number_show'] = $mlm_type_slug == 'licensed' ? $item['number_order'] : $item['number_lead'];
            $item['child_info'] = $childInfo;
            $item['created_at'] = date('H:i:s d-m-Y', strtotime($item['created_at']));
            return $item;
        }, $data);
        $result = [
            "draw" => 0,
            "recordsTotal" => count($data),
            "recordsFiltered" => $recordsFiltered,
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
}