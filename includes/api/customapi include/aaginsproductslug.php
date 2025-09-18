<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function insert_env($vars)
{
    $now = date('Y-m-d H:i:s');

    $array = [
        'product_id' => isset($vars['productId']) ? (int)$vars['productId'] : 0,
        'group_id'   => isset($vars['groupId']) ? (int)$vars['groupId'] : null,
        'group_slug' => isset($vars['groupSlug']) ? trim((string)$vars['groupSlug']) : null,
        'slug'       => isset($vars['slug']) ? trim((string)$vars['slug']) : '',
        'active'     => isset($vars['active']) ? (int)$vars['active'] : 1,
        'clicks'     => isset($vars['clicks']) ? (int)$vars['clicks'] : 0,
        'created_at' => isset($vars['createdAt']) ? (string)$vars['createdAt'] : $now,
        'updated_at' => isset($vars['updatedAt']) ? (string)$vars['updatedAt'] : $now,
    ];

    return (object)$array;
}

try {
    $post = insert_env(get_defined_vars());

    if ($post->product_id <= 0 || $post->slug === '') {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing required fields: product_id (>0) and slug"
        ];
        return;
    }

    $id = Capsule::table('tblproducts_slugs')->insertGetId([
        'product_id' => $post->product_id,
        'group_id'   => $post->group_id,
        'group_slug' => $post->group_slug,
        'slug'       => $post->slug,
        'active'     => $post->active,
        'clicks'     => $post->clicks,
        'created_at' => $post->created_at,
        'updated_at' => $post->updated_at,
    ]);

    $apiresults = [
        "result" => "success",
        "id"     => $id
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}
