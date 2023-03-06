<?php

namespace App\Http\Controllers\Agent\NonLicense;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $pathViewController     = "agents.pages.dashboard";
    private $controllerName         = "dashboard";
    private $routeName;
    private $prefix;
    private $prefix_group;
    private $model;
    private $params                 = [];
    function __construct()
    {
        // $this->model = new UserModel();
        $this->prefix = config('obn.license.prefix');
        $this->prefix_group = config('obn.license.prefix_group');
        $this->routeName = "{$this->prefix}/{$this->prefix_group}/{$this->controllerName}";
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
