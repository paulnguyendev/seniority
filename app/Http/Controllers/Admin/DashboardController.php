<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\SettingModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $pathViewController     = "staffs.pages.dashboard";
    private $controllerName         = "dashboard";
    private $routeName         = "staffs/dashboard";
    private $model;
    private $settingModel;
    private $params                 = [];
    function __construct()
    {
        // $this->model = new UserModel();
        $this->settingModel = new SettingModel();
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
    public function updateSetting(Request $request) {
        $params = $request->all();
        $this->settingModel->saveItem($params,['task' => 'edit-item']);
        return $params;
    }
}
