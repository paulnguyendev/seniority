<?php
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
if (!function_exists('get_thumbnail_url')) { 
    function get_thumbnail_url($thumbnail = "")
    {
        return  asset('uploads/images') . "/" . $thumbnail;
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
