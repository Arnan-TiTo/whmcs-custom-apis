<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function get_product_group_env($vars)
{
    $array = array(
        'name'            => $vars['name'] ?? null,
        'slug'            => $vars['slug'] ?? null,
        'headline'        => $vars['headline'] ?? '',
        'tagline'         => $vars['tagline'] ?? '',
        'orderfrmtpl'     => $vars['orderfrmtpl'] ?? '',
        'disabledgateways'=> $vars['disabledgateways'] ?? '',
        'hidden'          => isset($vars['hidden']) ? (int)$vars['hidden'] : 0,
        'order'           => isset($vars['order']) ? (int)$vars['order'] : 0,
        'created_at'      => $vars['created_at'] ?? date('Y-m-d H:i:s'),
        'updated_at'      => $vars['updated_at'] ?? date('Y-m-d H:i:s'),
    );

    return (object) $array;
}

try {
    $post_fields = get_product_group_env(get_defined_vars());

    if (empty($post_fields->name) || empty($post_fields->slug)) {
        $apiresults =  array("result" => "error", "message" => "Missing required fields (name, slug)");
    }

    $id = Capsule::table('tblproductgroups')->insertGetId([
        'name'            => $post_fields->name,
        'slug'            => $post_fields->slug,
        'headline'        => $post_fields->headline,
        'tagline'         => $post_fields->tagline,
        'orderfrmtpl'     => $post_fields->orderfrmtpl,
        'disabledgateways'=> $post_fields->disabledgateways,
        'hidden'          => $post_fields->hidden,
        'order'           => $post_fields->order,
        'created_at'      => $post_fields->created_at,
        'updated_at'      => $post_fields->updated_at,
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
