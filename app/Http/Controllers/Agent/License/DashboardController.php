<?php

namespace App\Http\Controllers\Agent\License;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $pathViewController     = "agents.pages.dashboard";
    private $controllerName         = "dashboard";
    private $routeName         = "agents/license/dashboard";
    private $model;
    private $params                 = [];
    function __construct()
    {
        // $this->model = new UserModel();
        View::share('controllerName', $this->controllerName);
    }
    public function index(Request $request)
    {
        return view(
            "{$this->pathViewController}/index",
            [
              
            ]
        );
    }
}
