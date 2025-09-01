<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];

    if (isset($vars['type'])) $fields['type'] = $vars['type'];
    if (isset($vars['name'])) $fields['name'] = $vars['name'];
    if (isset($vars['subject'])) $fields['subject'] = $vars['subject'];
    if (isset($vars['message'])) $fields['message'] = $vars['message'];
    if (isset($vars['attachments'])) $fields['attachments'] = $vars['attachments'];
    if (isset($vars['fromName'])) $fields['fromname'] = $vars['fromName'];
    if (isset($vars['fromEmail'])) $fields['fromemail'] = $vars['fromEmail'];
    if (isset($vars['disabled'])) $fields['disabled'] = (int)$vars['disabled'];
    if (isset($vars['custom'])) $fields['custom'] = (int)$vars['custom'];
    if (isset($vars['language'])) $fields['language'] = $vars['language'];
    if (isset($vars['copyTo'])) $fields['copyto'] = $vars['copyTo'];
    if (isset($vars['blindCopyTo'])) $fields['blind_copy_to'] = $vars['blindCopyTo'];
    if (isset($vars['plainText'])) $fields['plaintext'] = (int)$vars['plainText'];

    $fields['updated_at'] = date('Y-m-d H:i:s');

    return (object) $fields;
}

try {
    $id = (isset($vars['id']) && is_numeric($vars['id'])) ? (int)$vars['id'] : @$_REQUEST['id'];

    $update_fields = update_env(get_defined_vars());

    if (empty($id) || !is_numeric($id)) {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing or invalid 'id' parameter"
        ];
        return;
    }

    if (empty($update_fields->name) || empty($update_fields->subject) || empty($update_fields->message)) {
        $apiresults = [
            "result"  => "error",
            "message" => "Missing required fields (name, subject, message)"
        ];
        return;
    }

    if (!empty($update_fields->message)) {
        $msg = $update_fields->message ?? null;
        if ($msg !== null) {
            $msg = html_entity_decode($msg, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $msg = trim($msg);
            $update_fields->message = $msg;
        }
    }

    if (empty((array)$update_fields)) {
        $apiresults = [
            "result"  => "error",
            "message" => "No fields provided to update"
        ];
        return;
    }

    Capsule::table('tblemailtemplates')
        ->where('id', $id)
        ->update((array)$update_fields);

    $apiresults = [
        "result"     => "success",
        "id" => $id
    ];

} catch (Exception $e) {
    $apiresults = [
        "result"  => "error",
        "message" => $e->getMessage()
    ];
}

?>
