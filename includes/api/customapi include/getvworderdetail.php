<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be access directly!");
}

function get_env($vars)
{
    $array = array('whmcsOrderId' => array(), 'packageName' => array());
    //Post CURL
    $array['whmcsOrderId'] = $vars['whmcsOrderId'];
    $array['packageName'] = $vars['packageName'];

    return (object) $array;
}

try {

    $post_fields = get_env(get_defined_vars());

    $query = Capsule::table('vw_order_detail');

    if (isset($post_fields->whmcsOrderId))
    $query->where('whmcs_order_id', $post_fields->whmcsOrderId);

    if (isset($post_fields->packageName))
    $query->where('package_name', $post_fields->packageName);

    $results = $query->get();

    if (empty($results)) {
        throw new Exception('No data found');
    }

    $apiresults = array("result" => "success", "data" => $results);


} catch (Exception $e) {
    return ["result" => "error", "message" => $e->getMessage()];
}