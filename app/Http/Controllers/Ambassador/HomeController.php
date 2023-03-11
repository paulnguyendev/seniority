<?php

namespace App\Http\Controllers\Ambassador;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $pathViewController;
    private $controllerName         = "home";
    private $routeName;
    private $prefix;
    private $model;
    private $params                 = [];
    function __construct()
    {
        // $this->model = new UserModel();
        $this->prefix =  config('prefix.portal');
        $this->routeName = $this->prefix . "/" . $this->controllerName;
        $this->pathViewController = $this->prefix . ".pages." . $this->controllerName;
        View::share('controllerName', $this->controllerName);
        View::share('routeName', $this->routeName);
    }
    public function index(Request $request)
    {
        return view(
            "{$this->pathViewController}/index",
            []
        );
    }
}
