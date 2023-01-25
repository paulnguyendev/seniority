<?php
namespace Modules\Authen\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
class AuthenApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "authen::";
    private $controllerName         = "user_auth";
    private $moduleName         = "authen";
    private $model;
    private $params                 = [];
    function __construct()
    {
        $this->model = "";
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function login(Request $request)
    {
        $params = $request->all();
        return $params;
    }
    public function loginAdmin(Request $request)
    {
        $params = $request->all();
        return $params;
    }
    public function register(Request $request)
    {
        return view("{$this->pathViewController}register");
    }
    
}
