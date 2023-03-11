<?php

namespace App\Helpers;

use App\Models\AgentLicenseModel;
use App\Models\LicenseTransactionModel;
use Carbon\Carbon;

class License
{
    public static function getInfo($id = "", $key = "")
    {
        $sessionKey = config('session_key.licenseLogin');
        $model = new AgentLicenseModel();
        $thumbnail = null;
        $result = null;
        if (!$id) {
            $sessionLogin = session()->get($sessionKey);
            $sessionLogin = array_shift($sessionLogin) ?? [];
            $id = $sessionLogin->id;
        }
        $info = $model::find($id);
        if ($info) {
            if ($key) {
                if ($key == 'fullname') {
                    $first_name = $info['first_name'] ?? "";
                    $middle_name = $info['middle_name'] ?? "";
                    $last_name = $info['last_name'] ?? "";
                    $result = "{$first_name} {$middle_name} {$last_name}";
                } elseif ($key == 'thumbnail') {
                    $thumbnail = $info['thumbnail'] ?? "";
                    $result = $thumbnail ? asset('uploads/images') . "/" . $thumbnail : asset('themes/dashboard_v2/assets/images/users/avatar-1.jpg');
                } else {
                    $result = (isset($info[$key])) ? $info[$key] : "";
                }
            } else {
                $result = $info->toArray();
            }
        }
        return $result;
    }
    public static function count($id, $key = 'product')
    {
        $result = null;
        $model = new AgentLicenseModel();
        $transactionModel = new LicenseTransactionModel();
        $item = $model::find($id);
        if ($key == 'product') {
            $result = $item->products()->count();
        } elseif ($key == 'child') {
            $result = $model->descendantsOf($id)->count();
        } elseif ($key == 'last_month_transaction') {
            $result = $transactionModel->where('agent_id',$id)->whereMonth('created_at', Carbon::now()->month)->where('type','in')->sum('total');
        } elseif ($key == 'all_transaction') {
            $result = $transactionModel->where('agent_id',$id)->where('type','in')->sum('total');
        }
        return $result;
    }
}
