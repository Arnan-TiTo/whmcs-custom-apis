<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];

    if (isset($vars['id'])) $fields['id'] = $vars['id'];
    if (isset($vars['name'])) $fields['name'] = $vars['name'];
    if (isset($vars['slug'])) $fields['slug'] = $vars['slug'];
    if (isset($vars['headLine'])) $fields['headline'] = $vars['headLine'];
    if (isset($vars['tagLine'])) $fields['tagline'] = $vars['tagLine'];
    if (isset($vars['orderFrmTpl'])) $fields['orderfrmtpl'] = $vars['orderFrmTpl'];
    if (isset($vars['disabledGateways'])) $fields['disabledgateways'] = $vars['disabledGateways'];
    if (isset($vars['hidden'])) $fields['hidden'] = (int)$vars['hidden'];
    if (isset($vars['order'])) $fields['order'] = (int)$vars['order'];

    // auto update timestamp
    $fields['updated_at'] = date('Y-m-d H:i:s');

    return (object) $fields;
}

try {
    $update_fields = update_env(get_defined_vars());

    if (empty($update_fields->id) || !is_numeric($update_fields->id)) {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing or invalid 'id' parameter"
        ];
        return;
    }
    
    if (empty($update_fields)->name){
        $apiresults = [
            "result"  => "error",
            "message" => "Missing or invalid 'name' parameter"
        ];
        return;
    }

    $id = $update_fields->id;
    unset($update_fields['id']);

    Capsule::table('tblproductgroups')
        ->where('id', $id)
        ->update((array)$update_fields);

    $apiresults = [
        "result"     => "success",
        "updated_id" => $update_fields->id
    ];

} catch (Exception $e) {
    $apiresults = [
        "result"  => "error",
        "message" => $e->getMessage()
    ];
}

?>
