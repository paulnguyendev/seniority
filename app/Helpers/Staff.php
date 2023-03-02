<?php
namespace App\Helpers;

use App\Models\StaffModel;

class Staff {
    public static function getStaffInfo($staffId = "", $key = "") {
        $model = new StaffModel();
        $thumbnail = null;
        if (!$staffId) {
            $sessionLogin = session()->get('staffInfo');
            $sessionLogin = array_shift($sessionLogin) ?? [];
            $staffId = $sessionLogin->id;
            
        }
        $staffInfo = $model::find($staffId);
        if ($staffInfo) {
            if ($key) {
                if ($key == 'fullname') {
                    $first_name = $staffInfo['first_name'] ?? "";
                    $middle_name = $staffInfo['middle_name'] ?? "";
                    $last_name = $staffInfo['last_name'] ?? "";
                    $result = "{$first_name} {$middle_name} {$last_name}";
                } elseif ($key == 'thumbnail') {
                    $thumbnail = $staffInfo['thumbnail'] ?? "";
                    $result = $thumbnail ? asset('uploads/images') . "/" . $thumbnail : asset('themes/dashboard_v2/assets/images/users/avatar-1.jpg');
                } else {
                    $result = (isset($staffInfo[$key])) ? $staffInfo[$key] : "";
                }
            } else {
                $result = $staffInfo->toArray();
            }
        }
        return $result;
    }
}