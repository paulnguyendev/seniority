<?php
namespace App\Http\Controllers\License;
use App\Helpers\Level;
use App\Helpers\License;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\LevelLicenced\Entities\LevelLicencedModel;
class LoansController extends Controller
{
    private $pathViewController;
    private $controllerName         = "loans";
    private $routeName;
    private $prefix;
    private $model;
    private $licenseLevelModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new AgentLicenseModel();
        $this->licenseLevelModel = new LevelLicencedModel();
        $this->prefix =  config('prefix.portal_license');
        $this->routeName = $this->prefix . "/" . $this->controllerName;
        $this->pathViewController = $this->prefix . ".pages." . $this->controllerName;
        View::share('prefix', $this->prefix);
        View::share('controllerName', $this->controllerName);
        View::share('routeName', $this->routeName);
    }
    public function index(Request $request)
    {
        $ambassadorInfo = License::getInfo('');
        $ambassadorId = $ambassadorInfo['id'] ?? '';
      
  
        return view(
            "{$this->pathViewController}/index",
            [
                'ambassadorInfo' => $ambassadorInfo,
                'ambassadorId' => $ambassadorId,
                
            ]
        );
    }
}
