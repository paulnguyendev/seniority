<?php
namespace App\Http\Controllers\Agent;
use App\Helpers\Agent;
use App\Helpers\SendMail;
use App\Helpers\UserHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\AgentLicenseModel as MainModel;
class IndexController extends Controller
{
    private $pathViewController     = "agents.pages.";
    private $controllerName         = "index";
    private $routeName;
    private $prefix = "ambassador";
    private $prefix_group = "mortgage";
    private $model;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->routeName = "{$this->prefix}/{$this->prefix_group}/{$this->controllerName}";
        View::share('controllerName', $this->controllerName);
        View::share('routeName', $this->routeName);
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
