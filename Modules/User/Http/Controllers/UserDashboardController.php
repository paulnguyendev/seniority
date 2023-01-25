<?php
namespace Modules\User\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
class UserDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "user::pages.dashboard.";
    private $controllerName         = "user_dashboard";
    private $moduleName         = "user";
    private $model;
    private $params                 = [];
    function __construct()
    {
        $this->model = "";
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        return view("{$this->pathViewController}index", [
        ]);
    }
}
