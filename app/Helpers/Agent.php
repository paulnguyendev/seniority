<?php
namespace App\Helpers;

use App\Models\AgentLicenseModel;

class Agent {
    public static function getLicenseAgentInfo($agentId = "", $key = "") {
        $model = new AgentLicenseModel();
        $thumbnail = null;
        if (!$agentId) {
            $sessionLogin = session()->get('agentInfo');
            $sessionLogin = array_shift($sessionLogin) ?? [];
            $agentId = $sessionLogin->id;
            
        }
        $agentInfo = $model::find($agentId);
        if ($agentInfo) {
            if ($key) {
                if ($key == 'fullname') {
                    $first_name = $agentInfo['first_name'] ?? "";
                    $middle_name = $agentInfo['middle_name'] ?? "";
                    $last_name = $agentInfo['last_name'] ?? "";
                    $result = "{$first_name} {$middle_name} {$last_name}";
                } elseif ($key == 'thumbnail') {
                    $thumbnail = $agentInfo['thumbnail'] ?? "";
                    $result = $thumbnail ? asset('uploads/images') . "/" . $thumbnail : asset('themes/dashboard_v2/assets/images/users/avatar-1.jpg');
                } else {
                    $result = (isset($agentInfo[$key])) ? $agentInfo[$key] : "";
                }
            } else {
                $result = $agentInfo->toArray();
            }
        }
        return $result;
    }
    public static function showInfo($agentId) {
        $data = self::getLicenseAgentInfo($agentId);
        $fullname = self::getLicenseAgentInfo($agentId,'fullname');
        $mobile = $data['mobile'] ?? "";
        $mobile = show_phone($mobile);
        $email = $data['email'] ?? "-";
        $result = "{$fullname} <br> <small>Mobile: {$mobile}</small> <br> <small>Email: {$email}</small>";
        return $result;
    }
}