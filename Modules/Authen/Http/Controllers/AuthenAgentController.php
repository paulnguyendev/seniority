<?php
namespace Modules\Authen\Http\Controllers;

use App\Helpers\UserHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\Agent\Entities\AgentModel as MainModel;
use Modules\Agent\Entities\AgentModel;

class AuthenAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "authen::pages.agent.";
    private $controllerName         = "auth_agent";
    private $moduleName         = "authen";
    private $model;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function index(Request $request)
    {
        return view("{$this->pathViewController}index", [
        ]);
    }
    public function login(Request $request)
    {
        return view("{$this->pathViewController}login");
    }
    public function register(Request $request)
    {
        
        return view("{$this->pathViewController}register");
    }
    public function active(Request $request)
    {
        $token = $request->token;
        return view("{$this->pathViewController}active");
    }
    public function logout(Request $request)
    {
    }
    public function agentCheckParent(Request $request)
    {
        $params = $request->all();
        $item = $this->model->getItem($params, ['task' => 'code']);
        $id = null;
        $fullname = null;
        $thumbnail = null;
        if (!$item) {
            $msg = "Agent not found";
            $status = 400;
        } else {
            $status = 200;
            $msg = "Oke";
            $id = $item['id'];
            $fullname = UserHelper::getUserInfo($id,'fullname');
            $thumbnail = UserHelper::getUserInfo($id,'thumbnail');
        }
        $result = [
            'status' => $status,
            'msg' => $msg,
            'fullname' => $fullname,
            'id' => $id,
            'thumbnail' => $thumbnail,
        ];
        return $result;
    }
}
