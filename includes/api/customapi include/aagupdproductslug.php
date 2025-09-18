<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];

    if (isset($vars['groupId'])) {
        $fields['group_id'] = is_null($vars['groupId']) ? null : (int)$vars['groupId'];
    }
    if (isset($vars['groupSlug'])) {
        $fields['group_slug'] = is_null($vars['groupSlug']) ? null : trim((string)$vars['groupSlug']);
    }
    if (isset($vars['slug'])) {
        $fields['slug'] = trim((string)$vars['slug']);
    }
    if (isset($vars['active'])) {
        $fields['active'] = (int)$vars['active'];
    }
    if (isset($vars['clicks'])) {
        $fields['clicks'] = (int)$vars['clicks'];
    }

    $fields['updated_at'] = date('Y-m-d H:i:s');

    return (object)$fields;
}

try {
    if (empty($id) || !is_numeric($id) || (int)$id <= 0) {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing or invalid 'id' parameter"
        ];
        return;
    }

    $update_fields = update_env(get_defined_vars());

    if (empty((array)$update_fields)) {
        $apiresults = ["result" => "error", "message" => "No update fields provided"];
        return;
    }

    $exists = Capsule::table('tblproducts_slugs')->where('id', (int)$id)->first();

    if (!$exists) {
        $apiresults = ["result" => "error", "message" => "No record found with id = {$id}"];
        return;
    }


    Capsule::table('tblproducts_slugs')
        ->where('id', (int)$id)
        ->update((array)$update_fields);

    $results = Capsule::table('tblproducts_slugs')->where('id', (int)$id)->get();

    $apiresults = [
        "result" => "success",
        "id"     => (int)$id,
        "data"   => $results
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
