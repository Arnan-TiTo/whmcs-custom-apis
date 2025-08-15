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
        'headline'        => $vars['headLine'] ?? '',
        'tagline'         => $vars['tagLine'] ?? '',
        'orderfrmtpl'     => $vars['orderFrmTpl'] ?? '',
        'disabledgateways'=> $vars['disabledGateways'] ?? '',
        'hidden'          => isset($vars['hidden']) ? (int)$vars['hidden'] : 0,
        'order'           => isset($vars['order']) ? (int)$vars['order'] : 0,
        'createdAt'      => $vars['createdAt'] ?? date('Y-m-d H:i:s'),
        'updatedAt'      => $vars['updatedAt'] ?? date('Y-m-d H:i:s'),
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
        'headline'        => $post_fields->headLine,
        'tagline'         => $post_fields->tagLine,
        'orderfrmtpl'     => $post_fields->orderFrmTpl,
        'disabledgateways'=> $post_fields->disabledGateways,
        'hidden'          => $post_fields->hidden,
        'order'           => $post_fields->order,
        'createdAt'      => $post_fields->createdAt,
        'updatedAt'      => $post_fields->updatedAt,
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
