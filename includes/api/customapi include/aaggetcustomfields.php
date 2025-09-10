<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function get_env($vars)
{
    $array = [
        'relid'      => $vars['relid']      ?? null,
        'type'       => $vars['type']       ?? null,
        'fieldname'  => $vars['fieldname']  ?? null,
        'fieldtype'  => $vars['fieldtype']  ?? null,
        'order'      => $vars['order']      ?? 'asc',
    ];

    return (object)$array;
}

try {
    $post_fields = get_env(get_defined_vars());

    if (!isset($post_fields->relid) || !is_numeric($post_fields->relid)) {
        throw new Exception('Missing or invalid relid');
    }

    $query = Capsule::table('tblcustomfields')->where('relid', (int)$post_fields->relid);

    if (isset($post_fields->type) && $post_fields->type !== '') {
        $query->where('type', $post_fields->type);
    }
    if (isset($post_fields->fieldname) && $post_fields->fieldname !== '') {
        $query->where('fieldname', $post_fields->fieldname);
    }
    if (isset($post_fields->fieldtype) && $post_fields->fieldtype !== '') {
        $query->where('fieldtype', $post_fields->fieldtype);
    }


    $sortable = ['id','relid','fieldname','fieldtype','sortorder','created_at','updated_at'];
    if (isset($post_fields->sort) && in_array($post_fields->sort, $sortable, true)) {
        $order = strtolower($post_fields->order) === 'desc' ? 'desc' : 'asc';
        $query->orderBy($post_fields->sort, $order);
    }

    if (isset($post_fields->limit) && is_numeric($post_fields->limit)) {
        $query->limit((int)$post_fields->limit);
    }
    if (isset($post_fields->offset) && is_numeric($post_fields->offset)) {
        $query->offset((int)$post_fields->offset);
    }

    $results = $query->get();

    if ($results->isEmpty()) {
        throw new Exception('No data found');
    }

    $apiresults = [
        "result" => "success",
        "data"   => $results,
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}
