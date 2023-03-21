<?php
namespace App\Http\Controllers\Lead;
use App\Helpers\Level;
use App\Helpers\License;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel;
use App\Models\LeadModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\LevelLicenced\Entities\LevelLicencedModel;
class IndexController extends Controller
{
    private $pathViewController;
    private $controllerName         = "index";
    private $routeName;
    private $prefix;
    private $model;
    private $licenseLevelModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new LeadModel();
        $this->prefix =  config('prefix.lead');
        $this->routeName = $this->prefix . "/" . $this->controllerName;
        $this->pathViewController = $this->prefix . ".pages." . $this->controllerName;
        View::share('prefix', $this->prefix);
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
    public function save(Request $request) {
        $params = $request->all();
        $params['status'] = 'pending';
        $params['created_at'] = date('Y-m-d H:i:s');
        $this->model->saveItem($params,['task' => 'add-item']);
        return $params;
    }
}
