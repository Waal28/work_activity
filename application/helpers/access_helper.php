<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('generate_menu_access')) {
    function generate_menu_access($role) {
        $CI =& get_instance();
        $page_roles = $CI->config->item('page_roles');

        $access = [];
        foreach ($page_roles as $page => $roles) {
            $access[$page] = in_array($role, $roles);
        }
        return $access;
    }
}
