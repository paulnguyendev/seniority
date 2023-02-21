<?php
namespace Modules\Authen\Http\Controllers;
use App\Helpers\UserHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\Agent\Entities\AgentModel;
use Modules\User\Entities\UserModel as MainModel;
class AuthenApiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "authen::";
    private $controllerName         = "user_auth";
    private $moduleName         = "authen";
    private $model;
    private $agentModel;
    private $params                 = [];
    function __construct()
    {
        $this->model = new MainModel();
        $this->agentModel = new AgentModel();
        View::share('controllerName', $this->controllerName);
        View::share('moduleName', $this->moduleName);
    }
    public function login(Request $request)
    {
        $params = $request->all();
        return $params;
    }
    public function loginAdmin(Request $request)
    {
        $params = $request->all();
        $error = [];
        if (!$params['username']) {
            $error['username'] = "Please Enter Your Username";
        }
        if (!$params['password']) {
            $error['password'] = "Please Enter Your Password";
        }
        if (empty($error)) {
            $status = 200;
            $msg = "Login success";
            $user = $this->model->getItem($params, ['task' => 'login']);
            if (!$user) {
                $status = 400;
                $error['username'] = "Incorrect account login or password";
            } else {
                $type = $user['type'] ?? "user";
                if ($type != 'admin') {
                    $status = 400;
                    $error['username'] = "Your account does not have access to the system";
                }
            }
            if ($status == 400) {
                $msg = $error;
            } else {
                $request->session()->push('adminInfo', $user);
            }
        } else {
            $status = 400;
            $msg = $error;
        }
        $params['redirect'] = route('home_admin/index');
        $params['status'] = $status;
        $params['msg'] = $msg;
        return $params;
    }
    public function register(Request $request)
    {
        return view("{$this->pathViewController}register");
    }
   
   
}
