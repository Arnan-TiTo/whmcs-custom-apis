<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function get_env($vars)
{
    
    $array = array('id' => array());

    //Post CURL
    $array['id'] = $vars['id'];

    return (object) $array;
}

try {
    
    $post_fields = get_env(get_defined_vars());

    if (empty($post_fields->id) || !is_numeric($post_fields->id)) {
        $apiresults = array(
            "result" => "error",
            "message" => "Missing or invalid 'id' " .$post_fields->id." parameter"
        );
        return;
    }

    $exists = Capsule::table('tblemailtemplates')->where('id', $post_fields->id)->first();
    if (!$exists) {
        $apiresults = array(
            "result" => "error",
            "message" => "Record not found"
        );
        return;
    }

    Capsule::table('tblemailtemplates')->where('id', $post_fields->id)->delete();

    $apiresults = array(
        "result" => "success",
        "id" => $post_fields->id
    );

} catch (Exception $e) {
    $apiresults = array(
        "result" => "error",
        "message" => $e->getMessage()
    );
}

?>
