<?php
namespace App\Http\Controllers\License;
use App\Helpers\Level;
use App\Helpers\License;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\LevelLicenced\Entities\LevelLicencedModel;
class DownlineController extends Controller
{
    private $pathViewController;
    private $controllerName         = "downline";
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
        return view(
            "{$this->pathViewController}/index",
            []
        );
    }
    public function ambassador(Request $request)
    {
        $slug = $request->slug;
        $slug = $slug ? $slug : "mortgage";
        $item = $this->licenseLevelModel->getItem(['slug' => $slug], ['task' => 'slug']);
        $downlines = null;
        $ambassadorId = null;
        $levels = $this->licenseLevelModel->listItems(['is_break' => '0'], ['task' => 'list'])->toArray();
        $levels = array_reverse($levels);
        if ($item) {
            $ambassadorId = License::getInfo('', 'id');
            $levelId = $item['id'];
            $downlines =  $this->model::defaultOrder()->descendantsOf($ambassadorId)->where('level_id', $levelId)->where('status', 'active');
            return view(
                "{$this->pathViewController}/ambassador",
                [
                    'items' => $downlines,
                    'item' => $item,
                    'levels' => $levels,
                    'slug' => $slug,
                    'ambassadorId' => $ambassadorId,
                ]
            );
        } else {
            return redirect()->route($this->prefix . "/index");
        }
        return $slug;
    }
    public function loans(Request $request)
    {
        $slug = $request->slug;
        $slug = $slug ? $slug : "mortgage";
        $item = $this->licenseLevelModel->getItem(['slug' => $slug], ['task' => 'slug']);
        $downlines = null;
        $ambassadorId = null;
        $levels = $this->licenseLevelModel->listItems(['is_break' => '0'], ['task' => 'list'])->toArray();
        $levels = array_reverse($levels);
        if ($item) {
            $ambassadorId = License::getInfo('', 'id');
            $levelId = $item['id'];
            $downlines =  $this->model::defaultOrder()->descendantsOf($ambassadorId)->where('level_id', $levelId)->where('status', 'active');
            $applications = [];
            $loans = [];
            foreach ($downlines as $key => $item) {
                $applicationsOfAgent = $item
                    ->applications()
                    ->where('status', '!=', 'closed')
                    ->get()->toArray();
                $loansOfAgent = $item
                    ->products()
                    ->where('status', 'active')
                    ->get()->toArray();
                if(count($applicationsOfAgent) > 0) {
                    foreach ($applicationsOfAgent as $itemApplicationAgent) {
                        $applications[] = $itemApplicationAgent;
                    }
                  
                }
                if(count($loansOfAgent) > 0) {
                    foreach ($loansOfAgent as $itemLoanAgent) {
                        $loans[] = $itemLoanAgent;
                    }
                  
                }
                
            }
           
           
            
            return view(
                "{$this->pathViewController}/loans",
                [
                    'items' => $downlines,
                    'item' => $item,
                    'levels' => $levels,
                    'slug' => $slug,
                    'ambassadorId' => $ambassadorId,
                    'applications' => $applications,
                    'loans' => $loans,
                ]
            );
        } else {
            return redirect()->route($this->prefix . "/index");
        }
        return $slug;
    }
}
