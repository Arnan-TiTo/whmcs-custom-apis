<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];

    if (array_key_exists('name', $vars))                $fields['name']              = $vars['name'];
    if (array_key_exists('slug', $vars))                $fields['slug']              = $vars['slug'];
    if (array_key_exists('headLine', $vars))            $fields['headline']          = $vars['headLine'];
    if (array_key_exists('tagLine', $vars))             $fields['tagline']           = $vars['tagLine'];
    if (array_key_exists('orderFrmTpl', $vars))         $fields['orderfrmtpl']       = $vars['orderFrmTpl'];
    if (array_key_exists('disabledGateways', $vars))    $fields['disabledgateways']  = $vars['disabledGateways'];
    if (array_key_exists('hidden', $vars))              $fields['hidden']            = (int)$vars['hidden'];
    if (array_key_exists('order', $vars))               $fields['order']             = (int)$vars['order'];

    $fields['updated_at'] = date('Y-m-d H:i:s');

    return $fields;
}

try {
    $id = (isset($vars['id']) && is_numeric($vars['id'])) ? (int)$vars['id'] : @$_REQUEST['id'];

    $update_fields = update_env(get_defined_vars());

    if (empty($id) || !is_numeric($id)) {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing or invalid 'id' parameter"
        ];
        return;
    }

    if (array_key_exists('name', $update_fields) && trim((string)$update_fields['name']) === '') {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing or invalid 'name' parameter"
        ];
        return;
    }

    if (empty($update_fields)) {
        $apiresults = [
            "result"  => "error",
            "message" => "No fields to update"
        ];
        return;
    }

    Capsule::table('tblproductgroups')
        ->where('id', $id)
        ->update((array)$update_fields);

    $apiresults = [
        "result"     => "success",
        "id" => $id
    ];

} catch (\Throwable $e) {
    $apiresults = [
        "result"  => "error",
        "message" => $e->getMessage()
    ];
}
