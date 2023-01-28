<?php
namespace Modules\MLM\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\User\Entities\UserModel as MainModel;
use Illuminate\Support\Facades\Mail;
use Modules\Authen\Emails\SendVerifyEmail;
use Modules\MLM\Entities\MlmLevelModel;
use Modules\MLM\Entities\MlmTypeModel;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "mlm::pages.admin.";
    private $controllerName         = "mlm_admin";
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
        $slug = $request->slug;
        $mlmType = $this->mlmTypeModel->getItem(['slug' => $slug],['task' => 'slug']);
        return view("{$this->pathViewController}index", [
            'slug' => $slug,
            'mlmType' => $mlmType,
        ]);
    }
    public function level(Request $request)
    {
        $slug = $request->slug;
        $mlmType = $this->mlmTypeModel->getItem(['slug' => $slug],['task' => 'slug']);
        return view("{$this->pathViewController}level", [
            'slug' => $slug,
            'mlmType' => $mlmType,
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
    public function formLevel(Request $request)
    {
        $id = $request->id;
        $title = $id ? "Edit Item" : "Add Item";
        $slug = $request->slug;
        $mlmType = $this->mlmTypeModel->getItem(['slug' => $slug],['task' => 'slug']);
        return view("{$this->pathViewController}formLevel", [
            'title' => $title,
            'slug' => $slug,
            'mlmType' => $mlmType,
        ]);
    }
    public function trashIndex(Request $request)
    {
        return view("{$this->pathViewController}index", []);
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
    public function dataLevel(Request $request)
    {
        $data = [];
        $params = $request->all();
        $type_id = isset($params['type_id']) ? $params['type_id'] : "";
        $draw = isset($params['draw']) ? $params['draw'] : "";
        $start = isset($params['start']) ? $params['start'] : "";
        $length = isset($params['length']) ? $params['length'] : "";
        $search = isset($params['search']) ? $params['search'] : "";
        $searchValue = isset($search['value']) ? $search['value'] : "";
        if (!$searchValue) {
            $data = $this->mlmLevelModel->listItems(['start' => $start, 'length' => $length , 'mlm_type_id' => $type_id], ['task' => 'list']);
        } else {
            $data = $this->mlmLevelModel->listItems(['title' => $searchValue], ['task' => 'search']);
        }
        $data = $data->toArray();
        $data = array_map(function ($item) {
            $item['route_edit'] = route("{$this->controllerName}/formLevel", ['id' => $item['id']]);
            $item['route_remove'] = route("{$this->controllerName}/trash", ['id' => $item['id']]);
            $childId = $item['child_id'] ?? 0;
            $child = $this->mlmLevelModel::find($childId);
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
            "recordsTotal" => $this->model->count(),
            "recordsFiltered" => $this->model->count(),
            "data" => $data
        ];
        return $result;
    }
    public function trash(Request $request) {
        $id = $request->id;
        $this->mlmLevelModel->saveItem(['id' => $id, 'deleted_at' => date('Y-m-d H:i:s')], ['task' => 'edit-item']);
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