<?php
namespace Modules\Authen\Http\Controllers;
use App\Helpers\SendMail;
use App\Helpers\UserHelper;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Modules\Staff\Entities\StaffModel as MainModel;
use Modules\Agent\Entities\AgentModel;
class AuthenStaffController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    private $pathViewController     = "authen::pages.staff.";
    private $controllerName         = "auth_staff";
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
        return view("{$this->pathViewController}index", []);
    }
    public function login(Request $request)
    {
        return view("{$this->pathViewController}login");
    }
    public function register(Request $request)
    {
        return view("{$this->pathViewController}register");
    }
    public function forget(Request $request)
    {
        return view("{$this->pathViewController}forget");
    }
    public function active(Request $request)
    {
        $token = $request->token;
        $item = $this->model->getItem(['token' => $token], ['task' => 'token']);
        if (!$item) {
            return redirect()->route("{$this->controllerName}/login");
        }
        return view("{$this->pathViewController}active", [
            'token' => $token,
        ]);
    }
    public function logout(Request $request)
    {
        $request->session()->forget('agentInfo');
        return redirect()->route("{$this->controllerName}/login");
    }
    public function postLogin(Request $request)
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
                if($user['status'] == 'pending') {
                    $status = 400;
                    $error['username'] = "Your account is pending approval";
                }
            }
            if ($status == 400) {
                $msg = $error;
            } else {
                $request->session()->push('staffInfo', $user);
            }
        } else {
            $status = 400;
            $msg = $error;
        }
        $params['redirect'] = route('dashboard_staff/index');
        $params['status'] = $status;
        $params['msg'] = $msg;
        return $params;
    }
    public function quickLogin(Request $request) {
        $token = $request->token;
        $item = $this->model->getItem(['token' => $token],['task' => 'token']);
        if($item) {
            $request->session()->push('staffInfo', $item);
            return redirect()->route('dashboard_staff/index');
        }
        else {
            return redirect()->route('dashboard_staff/index');
        }
    }
}
