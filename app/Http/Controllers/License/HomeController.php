<?php
namespace App\Http\Controllers\License;
use App\Helpers\Level;
use App\Helpers\License;
use App\Http\Controllers\Controller;
use App\Models\AgentLicenseModel;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Modules\LevelLicenced\Entities\LevelLicencedModel;
class HomeController extends Controller
{
    private $pathViewController;
    private $controllerName         = "home";
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
        $childs = $ambassadorId ? Level::getLatestChildsOfAgent($ambassadorId) : [];
        #_Total Loans
        $totalLoans = $ambassadorId ? License::totalLoans($ambassadorId) : [];
        $totalDownlineIncomplete = $totalLoans['totalDownlineIncomplete'] ?? 0;
        $totalDownlineComplete = $totalLoans['totalDownlineComplete'] ?? 0;
        $totalDownlineLoans = $totalDownlineIncomplete +  $totalDownlineComplete;
        $totalChilds = License::count($ambassadorId,'child');
        $ambassadorData = $this->model::find($ambassadorId);
        $totalProducts = License::count($ambassadorId,'product');
        $commissionThisMonth = License::count($ambassadorId,'last_month_transaction');
        $commissionAll = License::count($ambassadorId,'all_transaction');
        $commissionPaid = License::count($ambassadorId,'paid_transaction');
        $levels = $this->licenseLevelModel->listItems(['is_break' => '0'],['task' => 'list'])->toArray();
        $levelIds = array_column($levels,'id');
        $levels = array_reverse($levels);
        return view(
            "{$this->pathViewController}/index",
            [
                'ambassadorInfo' => $ambassadorInfo,
                'ambassadorId' => $ambassadorId,
                'childs' => $childs,
                'totalChilds' => $totalChilds,
                'totalProducts' => $totalProducts,
                'commissionThisMonth' => $commissionThisMonth,
                'commissionAll' => $commissionAll,
                'levels' => $levels,
                'totalLoans' => $totalLoans,
                'commissionPaid' => $commissionPaid,
                'totalDownlineLoans' => $totalDownlineLoans,
            ]
        );
    }
}
