<?php
namespace App\Helpers;
use App\Models\AgentLicenseModel;
use App\Models\AgentNonLicenseModel;
class Agent {
    public static function getLicenseAgentInfo($agentId = "", $key = "") {
        $model = new AgentLicenseModel();
        $thumbnail = null;
        $result = null;
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
    public static function getNonLicenseAgentInfo($agentId = "", $key = "") {
        $model = new AgentNonLicenseModel();
        $thumbnail = null;
        $result = null;
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
    public static function showInfo($agentId,$type = 'license') {
        $data = $type == 'license' ? self::getLicenseAgentInfo($agentId) : self::getNonLicenseAgentInfo($agentId);
        $fullname =  $type == 'license' ?  self::getLicenseAgentInfo($agentId,'fullname') :  self::getNonLicenseAgentInfo($agentId,'fullname') ;
        $mobile = $data['mobile'] ?? "";
        $code = $data['code'] ?? "";
        $mobile = show_phone($mobile) ?? "-";
        $email = $data['email'] ?? "-";
        $levelId = $data['level_id'] ?? "";
        $rankingInfo = Level::getLevelInfo($levelId,'',$type) ?? [];
        $ranking = $rankingInfo['name'] ?? "-";
        $result = "{$fullname} <br> <small>ID: {$code}</small> <br> <small>Mobile: {$mobile}</small> <br> <small>Email: {$email}</small><br> <small>Ranking: {$ranking}</small>";
        return $result;
    }
}