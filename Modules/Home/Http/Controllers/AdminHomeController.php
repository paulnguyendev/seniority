<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;

class AdminHomeController extends Controller
{
   /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "home::pages.admin.";
    private $controllerName         = "admin_home";
    private $moduleName         = "home";
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
