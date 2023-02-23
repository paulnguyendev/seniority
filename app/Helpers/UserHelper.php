<?php

namespace App\Helpers;

use Modules\Agent\Entities\AgentModel;
use Modules\Staff\Entities\StaffModel;
use Modules\User\Entities\UserModel;

class UserHelper
{
    public static function getUserInfo($user_id = "", $key = "")
    {
        $model = new UserModel();
        $prefix =  request()->route()->getPrefix();
        $prefix = explode("/", $prefix);
        $prefixType = array_shift($prefix);
        $userSession = [];
        $result = null;
        if (!$user_id) {
            if ($prefixType == 'admin') {
                $userSession = session()->get('adminInfo');
            } elseif ($prefixType == 'agent') {
                $userSession = session()->get('agentInfo');
            } elseif ($prefixType == 'staff') {
                $userSession = session()->get('staffInfo');
            } else {
                $userSession = session()->get('userInfo');
            }
            $userSession = array_shift($userSession) ?? [];
            $user_id = $userSession->id;
        }
        if ($prefixType == 'agent') {
            $model = new AgentModel();
        } elseif ($prefixType == 'staff') {
            $model = new StaffModel();
        }

        $user = $model::find($user_id);
        $thumbnail = null;
        if ($user) {
            if ($key) {
                if ($key == 'fullname') {
                    $first_name = $user['first_name'] ?? "";
                    $middle_name = $user['middle_name'] ?? "";
                    $last_name = $user['last_name'] ?? "";
                    $result = "{$first_name} {$middle_name} {$last_name}";
                } elseif ($key == 'thumbnail') {
                    $thumbnail = $user['thumbnail'] ?? "";
                    $result = $thumbnail ? asset('uploads/images') . "/" . $thumbnail : asset('themes/dashboard_v2/assets/images/users/avatar-1.jpg');
                } else {
                    $result = (isset($user[$key])) ? $user[$key] : "";
                }
            } else {
                $result = $user->toArray();
            }
        }
        return $result;
    }
    public static function getAgentInfo($id, $key = "")
    {
        $model = new AgentModel();
        $item = $model::find($id);
        $result = null;
        if ($item) {
            if ($key) {
                if ($key == 'fullname') {
                    $first_name = $item['first_name'] ?? "";
                    $middle_name = $item['middle_name'] ?? "";
                    $last_name = $item['last_name'] ?? "";
                    $result = "{$first_name} {$middle_name} {$last_name}";
                } elseif ($key == 'thumbnail') {
                    $thumbnail = $item['thumbnail'] ?? "";
                    $result = $thumbnail ? asset('uploads/images') . "/" . $thumbnail : asset('themes/dashboard_v2/assets/images/users/avatar-1.jpg');
                } else {
                    $result = (isset($user[$key])) ? $user[$key] : "";
                }
            } else {
                $result = $item->toArray();
            }
        }
        return $result;
    }
    public static function showAgentInfo($id)
    {
        $xhtml = null;
        $item = self::getAgentInfo($id);
        $fullname = self::getAgentInfo($id, 'fullname');
        $code = $item['code'] ?? "-";
        $email = $item['email'] ?? "-";
        $mobile = $item['mobile'] ?? "";
        $username = $item['username'] ?? "";
        $mobile = $mobile ? show_phone($mobile) : "-";
        $type = $item['type'];
        $type = $type ? "-" . show_agent_type($type) : "";
        $xhtml = sprintf(
            '
        %s <br>
        <small>ID: %s %s</small><br>
        <small>Username: %s</small><br>
        <small>Email: %s</small><br>
        <small>Phone: %s</small> <br>',
            $fullname,
            $code,
            $type,
            $username,
            $email,
            $mobile,
        );
        return $xhtml;
    }
}
