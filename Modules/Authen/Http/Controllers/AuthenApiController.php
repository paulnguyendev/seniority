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
    public function agentSignup(Request $request)
    {
        $params = $request->all();
        $error = [];
        if (!$params['first_name']) {
            $error['first_name'] = "Please Enter Your First Name";
        }
        if (!$params['last_name']) {
            $error['last_name'] = "Please Enter Your Last Name";
        }
        if (!$params['email']) {
            $error['email'] = "Please Enter Your Email";
        }
        else {
            $checkMail = $this->agentModel->getItem(['email' => $params['email']],['task' => 'email']);
            if($checkMail) {
                $error['email'] = "Email already exists";
            }
        }
        if (!$params['mobile']) {
            $error['mobile'] = "Please Enter Your Mobile";
        }
        else {
            $params['mobile'] = clean($params['mobile']);
            $checkMobile = $this->agentModel->getItem(['mobile' => $params['mobile']],['task' => 'mobile']);
            if($checkMobile) {
                $error['mobile'] = "Mobile already exists";
            }
        }
        if (!$params['sponsor_id']) {
            $error['sponsor_id'] = "Please Enter Your Sponsor ID";
        }
        else {
            $user = $this->agentModel->getItem(['code' => $params['sponsor_id']],['task' => 'code']);
            if(!$user) {
                $error['sponsor_id'] = "Agent not found";
            }
            else {
                $params['parent_id'] = $user['id'];
            }
        }
        if (!$params['username']) {
            $error['username'] = "Please Enter Your Username";
        }
        else {
            $checkUsername = $this->agentModel->getItem(['username' => $params['username']],['task' => 'username']);
            if($checkUsername) {
                $error['username'] = "Username already exists";
            }
        }
        if (!$params['password']) {
            $error['password'] = "Please Enter Your Password";
        }
        if (empty($error)) {
            $status = 200;
            $msg = "Signup success";
            $params['status'] = 'pending';
            $params['created_at'] = date('Y-m-d H:i:s');
            $params['password'] = md5($params['password']);
            $params['code'] = random_code();
            $params['token'] = md5($params['email'].time());
            $this->agentModel->saveItem($params,['task' => 'add-item']);
        } else {
            $status = 400;
            $msg = $error;
        }
        $params['redirect'] = route('auth_agent/login');
        $params['status'] = $status;
        $params['msg'] = $msg;
        $params['error'] = $error;
        return $params;
    }
    public function loginAgent(Request $request)
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
            $user = $this->agentModel->getItem($params, ['task' => 'login']);
            if (!$user) {
                $status = 400;
                $error['username'] = "Incorrect account login or password";
            }
            else {
                if($user['status'] == 'pending') {
                    $status = 400;
                    $error['username'] = "Your account has not been activated";
                }
                elseif($user['is_suppend'] == '1') {
                    $status = 400;
                    $error['username'] = "Your account is suspended";
                }
            }
            if ($status == 400) {
                $msg = $error;
            } else {
                $request->session()->push('agentInfo', $user);
            }
        } else {
            $status = 400;
            $msg = $error;
        }
        $params['redirect'] = route('agent_dashboard/index');
        $params['status'] = $status;
        $params['msg'] = $msg;
        return $params;
    }
}
