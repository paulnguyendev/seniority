<?php
namespace App\Helpers;
use App\Models\AgentLicenseModel;
use App\Models\AgentNonLicenseModel;
use App\Models\SettingModel;

class Setting {
    public static function getValue($meta_key) {
        $model = new SettingModel();
        $data = $model->getItem(['meta_key' => $meta_key],['task' => 'meta_key']);
        $data = $data ? $data->toArray() : [];
        $result = isset($data['meta_value']) ? $data['meta_value'] : "";
        return $result;
    }
 
}