<?php
use Modules\Agent\Entities\AgentModel;
use Modules\User\Entities\UserModel;
if (!function_exists('get_logo')) {
    function get_logo()
    {
        return asset('themes/dashboard_v2/assets/obn/logo.png');
    }
}
if (!function_exists('get_site_name')) {
    function get_site_name()
    {
        return "Seniority";
    }
}
if (!function_exists('get_admin_url')) {
    function get_admin_url()
    {
        return route('home_admin/index');
    }
}
if (!function_exists('get_agent_url')) {
    function get_agent_url()
    {
        return route('dashboard_agent/index');
    }
}
if (!function_exists('get_staff_url')) {
    function get_staff_url()
    {
        return route('dashboard_staff/index');
    }
}
if (!function_exists('show_phone')) {
    function show_phone($phone)
    {
        $phone = "+1{$phone}";
        $result = null;
        if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $phone,  $matches ) )
        {
            $result = "(" . $matches[1] . ") "  .$matches[2] . '-' . $matches[3];
            return $result;
        }
    }
}
if (!function_exists('get_thumbnail_url')) {
    function get_thumbnail_url($thumbnail = "")
    {
        return  asset('uploads/images') . "/" . $thumbnail;
    }
}
if (!function_exists('get_default_thumbnail_url')) {
    function get_default_thumbnail_url($thumbnail = "default.png")
    {
        return   $thumbnail;
    }
}
if (!function_exists('show_status')) {
    function show_status($status = "default")
    {
        $xhtml_status = null;
        $status = $status ? $status : 'default';
        $tpl_status = config('obn.status.template');
        $current_status = isset($tpl_status[$status]) ? $tpl_status[$status] : $tpl_status['default'];
        $xhtml_status = sprintf('<span class = "badge badge-boxed  %s">%s</span>', $current_status['class'], $current_status['name']);
        return $xhtml_status;
    }
}
if (!function_exists('random_code')) {
    function random_code()
    {
        do {
            $code = random_int(100000, 999999);
        } while (AgentModel::where("code", "=", $code)->first());
        return config('obn.prefix.code') . $code;
    }
}
if (!function_exists('random_verify_code')) {
    function random_verify_code()
    {
        do {
            $code = random_int(100000, 999999);
        } while (AgentModel::where("verify_code", "=", $code)->first());
        return  $code;
    }
}
if (!function_exists('clean')) {
    function clean($string)
    {
        $t = $string;
        $specChars = array(
            ' ' => '-',    '!' => '',    '"' => '',
            '#' => '',    '$' => '',    '%' => '',
            '&' => '',    '\'' => '',   '(' => '',
            ')' => '',    '*' => '',    '+' => '',
            ',' => '',    '₹' => '',    '.' => '',
            '/-' => '',    ':' => '',    ';' => '',
            '<' => '',    '=' => '',    '>' => '',
            '?' => '',    '@' => '',    '[' => '',
            '\\' => '',   ']' => '',    '^' => '',
            '_' => '',    '`' => '',    '{' => '',
            '|' => '',    '}' => '',    '~' => '',
            '-----' => '-',    '----' => '-',    '---' => '-',
            '/' => '',    '--' => '-',   '/_' => '-', '-' => ''
        );
        foreach ($specChars as $k => $v) {
            $t = str_replace($k, $v, $t);
        }
        return $t;
    }
}
if (!function_exists('show_agent_type')) {
    function show_agent_type($status = "")
    {
        $xhtml_status = null;
        if($status) {
            $tpl_status = config('obn.agent_type');
            $current_status = isset($tpl_status[$status]) ? $tpl_status[$status] : $tpl_status['non-licensed'];
            $xhtml_status = sprintf('<span class = "badge badge-boxed  %s">%s</span>', $current_status['class'], $current_status['name']);
        }
       
        return $xhtml_status;
    }
}