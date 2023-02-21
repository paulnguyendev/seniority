<?php
namespace Modules\Dashboard\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\Agent\Entities\AgentModel as MainModel;
use Illuminate\Support\Facades\Mail;
class DashboardStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "dashboard::pages.staff.";
    private $controllerName         = "dashboard_staff";
    private $moduleName         = "dashboard";
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
        $totalAll = $this->model->whereNull('deleted_at')->count();
        $totalTrash = $this->model->whereNotNull('deleted_at')->count();
        return view("{$this->pathViewController}index", [
            'totalAll' => $totalAll,
            'totalTrash' => $totalTrash,
        ]);
    }
    public function form(Request $request)
    {
        $id = $request->id;
        $title = $id ? "Edit Item" : "Add Item";
        $item = [];
        $item = $this->model::findOrFail($id);
        return view("{$this->pathViewController}form", [
            'title' => $title,
            'item' => $item,
            'id' => $id,
        ]);
    }
}