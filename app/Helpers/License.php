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
            $result = $item->products()->where('status', 'complete')->count();
        } elseif ($key == 'child') {
            $result = $model->descendantsOf($id)->where('status', 'active')->count();
        } elseif ($key == 'last_month_transaction') {
            $result = $transactionModel->where('agent_id', $id)->whereMonth('created_at', Carbon::now()->month)->where('type', 'in')->sum('total');
        } elseif ($key == 'all_transaction') {
            $result = $transactionModel->where('agent_id', $id)->where('type', 'in')->sum('total');
        } elseif ($key == 'paid_transaction') {
            $result = $transactionModel->where('agent_id', $id)->where('type', 'in')->where('status', 'paid')->sum('total');
        }
        return $result;
    }
    public static function totalLoans($id)
    {
        $result = null;
        $model = new AgentLicenseModel();
        $item = $model::find($id);
        $totalMyComplete = $item->products()->where('status', 'active')->count();
        $totalMyIncomplete = $item->applications()->where('status', '!=', 'closed')->count();
        $downlines = $model->descendantsOf($id)->toArray();
        $totalDownlineIncomplete = 0;
        $totalDownlineComplete = 0;
        if (count($downlines) > 0) {
            foreach ($downlines as $downline) {
                $item = $model::find($downline['id']);
                $totalDownlineIncomplete += $item->applications()->where('status', '!=', 'closed')->count();;
                $totalDownlineComplete += $item->products()->where('status', 'active')->count();
            }
        }

        $result = [
            'totalMyComplete' => $totalMyComplete,
            'totalMyIncomplete' => $totalMyIncomplete,
            'totalDownlineIncomplete' => $totalDownlineIncomplete,
            'totalDownlineComplete' => $totalDownlineComplete,
        ];
        return $result;
    }
    public static function showInfo($agentId)
    {
        $data = self::getInfo($agentId);
        $fullname = self::getInfo($agentId,'fullname');
        $mobile = $data['mobile'] ?? "";
        $code = $data['code'] ?? "";
        $mobile = show_phone($mobile) ?? "-";
        $email = $data['email'] ?? "-";
        $levelId = $data['level_id'] ?? "";
       
        $result = "{$fullname} <br> <small>ID: {$code}</small> <br> <small>Mobile: {$mobile}</small> <br> <small>Email: {$email}</small><br>";
        return $result;
    }
}
