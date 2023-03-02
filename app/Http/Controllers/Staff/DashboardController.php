<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $pathViewController     = "staffs.pages.dashboard";
    private $controllerName         = "dashboard";
    private $routeName         = "staffs/dashboard";
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
