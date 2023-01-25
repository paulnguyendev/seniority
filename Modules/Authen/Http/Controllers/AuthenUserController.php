<?php
namespace Modules\Authen\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
class AuthenUserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "authen::pages.user.";
    private $controllerName         = "auth_user";
    private $moduleName         = "authen";
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
    public function login(Request $request)
    {
        return view("{$this->pathViewController}login");
    }
    public function register(Request $request)
    {
        return view("{$this->pathViewController}register");
    }
    public function active(Request $request)
    {
        $token = $request->token;
        return view("{$this->pathViewController}active");
    }
    public function logout(Request $request)
    {
    }
}
