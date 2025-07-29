<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be access directly!");
}

function get_env($vars)
{
    $array = array('whmcs_order_id' => array(), 'package_name' => array());
    //Post CURL
    $array['whmcs_order_id'] = $vars['whmcs_order_id'];
    $array['package_name'] = $vars['package_name'];

    return (object) $array;
}

try {

    $post_fields = get_env(get_defined_vars());

    $query = Capsule::table('vw_order_detail');

    if (isset($post_fields->whmcs_order_id))
    $query->where('whmcs_order_id', $post_fields->whmcs_order_id);   
    
    if (isset($post_fields->package_name))
    $query->where('package_name', $post_fields->package_name);   

    $results = $query->get();

    if (empty($results)) {
        throw new Exception('No data found');
    }

    $apiresults = array("result" => "success", "data" => $results);


} catch (Exception $e) {
    return ["result" => "error", "message" => $e->getMessage()];
}