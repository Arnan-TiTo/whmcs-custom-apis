<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function insert_env($vars)
{
    $array = array(
        'name'            => $vars['name'] ?? null,
        'slug'            => $vars['slug'] ?? null,
        'headLine'        => $vars['headLine'] ?? '',
        'tagLine'         => $vars['tagLine'] ?? '',
        'orderFrmTpl'     => $vars['orderFrmTpl'] ?? '',
        'disabledGateways'=> $vars['disabledGateways'] ?? '',
        'hidden'          => isset($vars['hidden']) ? (int)$vars['hidden'] : 0,
        'order'           => isset($vars['order']) ? (int)$vars['order'] : 0,
        'created_At'      => $vars['created_At'] ?? date('Y-m-d H:i:s'),
        'updated_At'      => $vars['updated_At'] ?? date('Y-m-d H:i:s'),
    );

    return (object) $array;
}

try {
    $post_fields = insert_env(get_defined_vars());

    if (empty($post_fields->name) || empty($post_fields->slug)) {
        $apiresults =  array("result" => "error", "message" => "Missing required fields (name, slug)");
    }

    $id = Capsule::table('tblproductgroups')->insertGetId([
        'name'            => $post_fields->name,
        'slug'            => $post_fields->slug,
        'headline'        => $post_fields->headLine,
        'tagline'         => $post_fields->tagLine,
        'orderfrmtpl'     => $post_fields->orderFrmTpl,
        'disabledgateways'=> $post_fields->disabledGateways,
        'hidden'          => $post_fields->hidden,
        'order'           => $post_fields->order,
        'created_At'      => $post_fields->created_At,
        'updated_At'      => $post_fields->updated_At,
    ]);

    $apiresults = array(
        "result" => "success",
        "id"     => $id,
        "name"   => $post_fields->name
    );

} catch (Exception $e) {
    $apiresults = array("result" => "error", "message" => $e->getMessage());
}

?>
