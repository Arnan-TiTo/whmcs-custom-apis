<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function get_env($vars)
{
    $array = [
        'product_id' => isset($vars['productId']) ? (int)$vars['productId'] : 0,
        'active'     => isset($vars['active']) ? (int)$vars['active'] : null,
    ];
    return (object)$array;
}

try {
    $post_fields = get_env(get_defined_vars());

    if ($post_fields->product_id <= 0) {
        $apiresults = ["result" => "error", "message" => "product_id is required (>0)"];
        return;
    }

    $orderable = ['id','product_id','group_id','group_slug','slug','active','clicks','created_at','updated_at'];
    if (!in_array($q->order_by, $orderable, true)) {
        $post_fields->order_by = 'updated_at';
    }

    if (!in_array($post_fields->order_dir, ['ASC','DESC'], true)) {
        $post_fields->order_dir = 'DESC';
    }

    $query = Capsule::table('tblproducts_slugs')->where('product_id', $post_fields->product_id);

    if ($post_fields->active !== null) {
        $query->where('active', $post_fields->active);
    }

    $total = (clone $query)->count();

    $rows = $query
        ->orderBy($post_fields->order_by, $post_fields->order_dir)
        ->get();

    $apiresults = [
        "result" => "success",
        "data"   => $rows,
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}
