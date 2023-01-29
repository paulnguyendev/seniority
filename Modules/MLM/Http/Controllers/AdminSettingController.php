<?php
namespace Modules\MLM\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\MLM\Entities\MlmSettingModel as MainModel;
use Illuminate\Support\Facades\Mail;
use Modules\Authen\Emails\SendVerifyEmail;
use Modules\MLM\Entities\MlmLevelModel;
use Modules\MLM\Entities\MlmTypeModel;
class AdminSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "mlm::pages.admin.setting.";
    private $controllerName         = "mlm_admin_setting";
    private $moduleName         = "mlm";
    private $model;
    private $mlmLevelModel;
    private $mlmTypeModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->mlmTypeModel = new MlmTypeModel();
        $this->mlmLevelModel = new MlmLevelModel();
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        $level_id = $request->level_id;
        $mlmLevel = $this->mlmLevelModel::findOrFail($level_id);
        $mlmType = $mlmLevel->type()->first();
        $totalAll = $this->model->whereNull('deleted_at')->where('mlm_level_id', $level_id)->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->where('mlm_level_id', $level_id)->count();
        return view("{$this->pathViewController}index", [
            'totalAll' => $totalAll,
            'mlmLevel' => $mlmLevel,
            'totalTrash' => $totalTrash,
            'level_id' => $level_id,
            'mlmType' => $mlmType,
        ]);
    }
    public function form(Request $request)
    {
        $id = $request->id;
        $level_id = $request->level_id;
        $mlmLevel = $this->mlmLevelModel::findOrFail($level_id);
        $mlmType = $mlmLevel->type()->first();
        $levels = $this->mlmLevelModel->listItems(['mlm_type_id' => $mlmType['id']],['task' => 'list']);
        $title = $id ? "Edit Item" : "Add Item";
        $item = null;
        if($id) {
            $item = $this->model::findOrFail($id);
        }
        return view("{$this->pathViewController}form", [
            'title' => $title,
            'mlmLevel' => $mlmLevel,
            'level_id' => $level_id,
            'levels' => $levels,
            'item' => $item,
            'id' => $id,
        ]);
    }
    public function trashIndex(Request $request)
    {
        $level_id = $request->level_id;
        $mlmLevel = $this->mlmLevelModel::findOrFail($level_id);
        $mlmType = $mlmLevel->type()->first();
        $totalAll = $this->model->whereNull('deleted_at')->where('mlm_level_id', $level_id)->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->where('mlm_level_id', $level_id)->count();
        return view("{$this->pathViewController}trash", [
            'totalAll' => $totalAll,
            'mlmLevel' => $mlmLevel,
            'totalTrash' => $totalTrash,
            'level_id' => $level_id,
            'mlmType' => $mlmType,
        ]);
    }
    public function save(Request $request)
    {
        $params = $request->all();
        $level_id = $params['mlm_level_id'] ?? "";
        $id = $request->id;
        $params['redirect'] = "";
        $error = [];
        if (!$params['name']) {
            $error['name'] = "Please enter name";
        }
        if (!$params['commission']) {
            $error['commission'] = "Please enter Commission";
        }
        else {
            if(!is_numeric($params['commission'])) {
                $error['commission'] = "Please enter Commission number";
            }
        }
        if (empty($error)) {
            $status = 200;
            $params['created_at'] = date('Y-m-d H:i:s');
            if($id) {
                $params['id'] = $id;
                $this->model->saveItem($params, ['task' => 'edit-item']);
                $msg = "Update MLM Setting Success";
            }
            else {
                $this->model->saveItem($params, ['task' => 'add-item']);
                $msg = "Add MLM Setting Success";
                $params['redirect'] = route("{$this->controllerName}/index",['level_id' => $level_id]);
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
        $level_id = $request->level_id;
        $is_trash = isset($params['is_trash']) ? $params['is_trash'] : "0";
        $draw = isset($params['draw']) ? $params['draw'] : "";
        $start = isset($params['start']) ? $params['start'] : "";
        $length = isset($params['length']) ? $params['length'] : "";
        $search = isset($params['search']) ? $params['search'] : "";
        $searchValue = isset($search['value']) ? $search['value'] : "";
        $paramsData['is_trash'] = $is_trash;
        $paramsData['level_id'] = $level_id;
        if (!$searchValue) {
            $paramsData['start'] = $start;
            $paramsData['length'] = $length;
            $data = $this->model->listItems($paramsData, ['task' => 'list']);
        } else {
            $paramsData['title'] = $searchValue;
            $data = $this->model->listItems($paramsData, ['task' => 'search']);
        }
        $data = $data->toArray();
        $recordsFiltered = $this->model->whereNull('deleted_at')->where('mlm_level_id', $level_id)->count();
        $data = array_map(function ($item) use ($level_id) {
            $item['route_edit'] = route("{$this->controllerName}/form", ['id' => $item['id'], 'level_id' => $level_id]);
            $item['route_remove'] = route("{$this->controllerName}/trash", ['id' => $item['id'], 'level_id' => $level_id]);
            $item['route_delete'] = route("{$this->controllerName}/delete", ['id' => $item['id'], 'level_id' => $level_id]);
            $item['route_restore'] = route("{$this->controllerName}/updateField", ['id' => $item['id'],'task' => 'restore', 'level_id' => $level_id]);
            $commission = $item['commission'];
            $commission_type = $item['commission_type'];
            $commission_type = $commission_type == 'percentage' ? "%" : "$";
            $commission_show = "{$commission} {$commission_type} ";
            $item['commission_show'] = $commission_show;
            $commission_group = $item['commission_group'];
            $mlm_indirect_level_id = $item['mlm_indirect_level_id'];
            $mlmIndirectLevelName = $mlm_indirect_level_id ? $this->mlmLevelModel::find($mlm_indirect_level_id)->name : "";
            $commission_group_show =  $commission_group == 'direct' ? "Direct" : "Indirect <br> <small> Level: {$mlmIndirectLevelName} </small>";
            $item['commission_group_show'] = $commission_group_show;
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