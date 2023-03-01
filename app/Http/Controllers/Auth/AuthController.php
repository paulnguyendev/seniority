<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $pathViewController     = "agents.pages.auth";
    private $controllerName         = "auth";
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
    public function login(Request $request)
    {
        return view(
            "{$this->pathViewController}/login",
            [
              
            ]
        );
    }
}
