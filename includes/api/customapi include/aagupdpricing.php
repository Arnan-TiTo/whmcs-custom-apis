<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];

    if (isset($vars['type'])) $fields['type'] = $vars['type'];
    if (isset($vars['currency'])) $fields['currency'] = $vars['currency'];
    if (isset($vars['relid'])) $fields['relid'] = $vars['relid'];
    if (isset($vars['mSetupFee'])) $fields['msetupfee'] = $vars['mSetupFee'];
    if (isset($vars['qSetupFee'])) $fields['qsetupfee'] = $vars['qSetupFee'];
    if (isset($vars['sSetupFee'])) $fields['ssetupfee'] = $vars['sSetupFee'];
    if (isset($vars['aSetupFee'])) $fields['asetupfee'] = $vars['aSetupFee'];
    if (isset($vars['bSetupFee'])) $fields['bsetupfee'] = $vars['bSetupFee'];
    if (isset($vars['tSetupFee'])) $fields['tsetupfee'] = $vars['tSetupFee'];
    if (isset($vars['monthly'])) $fields['monthly'] = $vars['monthly'];
    if (isset($vars['quarterly'])) $fields['quarterly'] = $vars['quarterly'];
    if (isset($vars['semiAnnually'])) $fields['semiannually'] = $vars['semiAnnually'];
    if (isset($vars['annually'])) $fields['annually'] = $vars['annually'];
    if (isset($vars['biennially'])) $fields['biennially'] = $vars['biennially'];
    if (isset($vars['triennially'])) $fields['triennially'] = $vars['triennially'];

    return (object) $fields;
}

try {
    $id = (isset($vars['id']) && is_numeric($vars['id'])) ? (int)$vars['id'] : @$_REQUEST['id'];

    $update_fields = update_env(get_defined_vars());

    if (empty($id) || !is_numeric($id)) {
        $apiresults = array(
            "result" => "error",
            "message" => "Missing or invalid 'id' parameter"
        );
        return;
    }    

    if (empty($update_fields->type) || empty($update_fields->currency) || empty($update_fields->relid)) {
        $apiresults = ["result" => "error", "message" => "Missing required fields (type, currency, relid)"];
        return;
    }

    if (!is_numeric($update_fields->msetupfee)    || !is_numeric($update_fields->qsetupfee) ||
        !is_numeric($update_fields->ssetupfee)    || !is_numeric($update_fields->asetupfee) ||
        !is_numeric($update_fields->bsetupfee)    || !is_numeric($update_fields->tsetupfee) ||
        !is_numeric($update_fields->monthly)      || !is_numeric($update_fields->quarterly) ||
        !is_numeric($update_fields->semiannually) || !is_numeric($update_fields->annually) ||
        !is_numeric($update_fields->biennially)   || !is_numeric($update_fields->triennially)) {
        $apiresults = ["result" => "error", "message" => "Invalid pricing values"];
        return;
    }

    if (empty($update_fields)) {
        $apiresults = ["result" => "error", "message" => "No fields provided to update"];
        return;
    }

    Capsule::table('tblpricing')
        ->where('id', $id)
        ->update((array)$update_fields);

    $apiresults = [
        "result" => "success",
        "updated_id" => $id
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
