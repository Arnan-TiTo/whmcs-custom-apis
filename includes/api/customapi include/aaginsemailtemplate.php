<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be access directly!");
}

function get_env($vars)
{
    $array = array(
     'type'       => array(),
     'name'     => array(),
     'subject'     => array(),
     'message'     => array(),
     'fromemail'     => array(),
     'fromname'     => array(),
     'language'     => array(),
     'icopytod'     => array(),
     'blind_copy'     => array(),
     'attachments'     => array(),
     'plaintext'     => array(),
     'disabled'     => array()

    );
    
    //Post CURL
    $array['type']        = $vars['type'] ?? 'general';
    $array['name']        = $vars['name'] ?? null;
    $array['subject']     = $vars['subject'] ?? null;
    $array['message']     = $vars['message'] ?? null;
    $array['fromemail']   = $vars['fromemail'] ?? '';
    $array['fromname']    = $vars['fromname'] ?? '';
    $array['language']    = $vars['language'] ?? '';
    $array['icopytod']     = $vars['copyto'] ?? '';
    $array['blind_copy']  = $vars['blind_copy_to'] ?? '';
    $array['attachments'] = $vars['attachments'] ?? '';
    $array['plaintext']   = isset($vars['plaintext']) ? (int)$vars['plaintext'] : 0;
    $array['disabled']    = isset($vars['disabled']) ? (int)$vars['disabled'] : 0;    

    if (!empty($vars['message_b64'])) {
        $decoded = base64_decode($vars['message_b64'], true);
        $array['message'] = ($decoded === false) ? null : $decoded;
    } else {
        $msg = $vars['message'] ?? null;
        if ($msg !== null) {
            $msg = html_entity_decode($msg, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        $array['message'] = $msg;
    }    

    return (object) $array;
}


try {

    $post_fields = get_env(get_defined_vars());

    if (empty($post_fields->name)||empty($post_fields->subject)||empty($post_fields->message)) {
        $apiresults = array("result" => "error", "message" => "Missing required fields (name, subject, message)");
    }

    $id = Capsule::table('tblemailtemplates')->insertGetId([
        'type'          => $post_fields->type,
        'name'          => $post_fields->name,
        'subject'       => $post_fields->subject,
        'message'       => $post_fields->message,
        'attachments'   => $post_fields->attachments,
        'fromemail'     => $post_fields->fromemail,
        'fromname'      => $post_fields->fromname,
        'disabled'      => $post_fields->disabled,
        'custom'        => 1,
        'language'      => $post_fields->language,
        'copyto'        => $post_fields->icopytod,
        'blind_copy_to' => $post_fields->blind_copy,
        'plaintext'     => $post_fields->plaintext,
    ]);

    $apiresults = array("result" => "success", "id" => $id);

} catch (Exception $e) {
    return ["result" => "error", "message" => $e->getMessage()];
}


?>