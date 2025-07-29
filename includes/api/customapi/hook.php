<?php

use WHMCS\Module\Addon\Customapi\Helper;
use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}


require_once __DIR__ . './getproductdetail.php';

add_hook('APIRequest', 1, function($vars) {
    if ($vars['action'] === 'getorderdetail') {
        return get_order_detail($vars);
    }
    if ($vars['action'] === 'insertemailtemplate') {
        return insert_email_template($vars);
    }
});

function get_order_detail($vars)
{
    try {
        $query = Capsule::table('vw_order_detail');

        if (!empty($vars['whmcs_order_id'])) {
            $query->where('whmcs_order_id', $vars['whmcs_order_id']);
        }
        if (!empty($vars['package_name'])) {
            $query->where('package_name', 'like', '%' . $vars['package_name'] . '%');
        }
        if (!empty($vars['product_name'])) {
            $query->where('product_name', 'like', '%' . $vars['product_name'] . '%');
        }
        if (!empty($vars['invoice_status'])) {
            $query->where('invoice_status', $vars['invoice_status']);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return ["result" => "error", "message" => "No records found"];
        }

        return [
            "result" => "success",
            "totalresults" => $data->count(),
            "data" => $data
        ];

    } catch (Exception $e) {
        return ["result" => "error", "message" => $e->getMessage()];
    }
}

function insert_email_template($vars)
{
    try {
        $type        = $vars['type'] ?? 'general';
        $name        = $vars['name'] ?? null;
        $subject     = $vars['subject'] ?? null;
        $message     = $vars['message'] ?? null;
        $fromemail   = $vars['fromemail'] ?? '';
        $fromname    = $vars['fromname'] ?? '';
        $language    = $vars['language'] ?? '';
        $copyto      = $vars['copyto'] ?? '';
        $blind_copy  = $vars['blind_copy_to'] ?? '';
        $attachments = $vars['attachments'] ?? '';
        $plaintext   = isset($vars['plaintext']) ? (int)$vars['plaintext'] : 0;
        $disabled    = isset($vars['disabled']) ? (int)$vars['disabled'] : 0;

        if (empty($name) || empty($subject) || empty($message)) {
            return ["result" => "error", "message" => "Missing required fields (name, subject, message)"];
        }

        $id = Capsule::table('tblemailtemplates')->insertGetId([
            'type'         => $type,
            'name'         => $name,
            'subject'      => $subject,
            'message'      => $message,
            'attachments'  => $attachments,
            'fromemail'    => $fromemail,
            'fromname'     => $fromname,
            'disabled'     => $disabled,
            'custom'       => 1, 
            'language'     => $language,
            'copyto'       => $copyto,
            'blind_copy_to'=> $blind_copy,
            'plaintext'    => $plaintext,
        ]);

        return [
            "result" => "success",
            "message" => "Email template inserted successfully",
            "id" => $id
        ];

    } catch (Exception $e) {
        return ["result" => "error", "message" => $e->getMessage()];
    }
}
