<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function flag_on($v): string
{
    if (is_string($v)) {
        return (strtolower($v) === 'on' || strtolower($v) === 'true' || $v === '1') ? 'on' : '';
    }
    return ($v === true || $v === 1) ? 'on' : '';
}

function insert_env($vars)
{
    $now = date('Y-m-d H:i:s');

    $array = [
        'type'         => $vars['type']        ?? 'product', 
        'relid'        => isset($vars['relid']) ? (int)$vars['relid'] : 0,
        'fieldname'    => $vars['fieldname']   ?? 'Password',
        'fieldtype'    => $vars['fieldtype']   ?? 'password',
        'description'  => $vars['description'] ?? '',
        'fieldoptions' => $vars['fieldoptions']?? '',
        'regexpr'      => $vars['regexpr']     ?? '',
        'adminonly'    => flag_on($vars['adminonly']   ?? ''),
        'required'     => flag_on($vars['required']    ?? ''),
        'showorder'    => flag_on($vars['showorder']   ?? ''),
        'showinvoice'  => flag_on($vars['showinvoice'] ?? ''),
        'sortorder'    => isset($vars['sortorder']) ? (int)$vars['sortorder'] : 0,
        'created_at'   => $vars['created_at']  ?? $now,
        'updated_at'   => $vars['updated_at']  ?? $now,
    ];

    return (object)$array;
}

try {
    $post_fields = insert_env(get_defined_vars());

    if (empty($post_fields->type) || empty($post_fields->fieldname) || empty($post_fields->fieldtype)) {
        $apiresults = ["result" => "error", "message" => "Missing required fields (type, fieldname, fieldtype)"];
        return;
    }

    if (!is_numeric($post_fields->relid) || (int)$post_fields->relid < 0) {
        $apiresults = ["result" => "error", "message" => "Invalid relid"];
        return;
    }

    $allowedTypes = ['text','password','link','dropdown','tickbox','textarea'];
    if (!in_array(strtolower($post_fields->fieldtype), $allowedTypes, true)) {
        $apiresults = ["result" => "error", "message" => "Unsupported fieldtype"];
        return;
    }

    if ($post_fields->fieldtype === 'dropdown' && trim((string)$post_fields->fieldoptions) === '') {
        $apiresults = ["result" => "error", "message" => "Dropdown requires fieldoptions"];
        return;
    }

    $id = Capsule::table('tblcustomfields')->insertGetId((array)$post_fields);

    $apiresults = [
        "result" => "success",
        "id"     => $id
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
