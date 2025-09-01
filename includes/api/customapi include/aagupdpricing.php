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
    $fields['msetupfee']     = isset($vars['mSetupFee'])     ? $vars['mSetupFee']     : 0;
    $fields['qsetupfee']     = isset($vars['qSetupFee'])     ? $vars['qSetupFee']     : 0;
    $fields['ssetupfee']     = isset($vars['sSetupFee'])     ? $vars['sSetupFee']     : 0;
    $fields['asetupfee']     = isset($vars['aSetupFee'])     ? $vars['aSetupFee']     : 0;
    $fields['bsetupfee']     = isset($vars['bSetupFee'])     ? $vars['bSetupFee']     : 0;
    $fields['tsetupfee']     = isset($vars['tSetupFee'])     ? $vars['tSetupFee']     : 0;
    $fields['monthly']       = isset($vars['monthly'])       ? $vars['monthly']       : 0;
    $fields['quarterly']     = isset($vars['quarterly'])     ? $vars['quarterly']     : 0;
    $fields['semiannually']  = isset($vars['semiAnnually'])  ? $vars['semiAnnually']  : 0;
    $fields['annually']      = isset($vars['annually'])      ? $vars['annually']      : 0;
    $fields['biennially']    = isset($vars['biennially'])    ? $vars['biennially']    : 0;
    $fields['triennially']   = isset($vars['triennially'])   ? $vars['triennially']   : 0;

    return (object) $fields;
}

try {

    $update_fields = update_env(get_defined_vars());

    if (empty($relid) || !is_numeric($relid)|| $relid <= 0) {
        $apiresults = array(
            "result" => "error",
            "message" => "Missing or invalid 'relid' parameter"
        );
        return;
    }    

    if (empty($update_fields->currency) || empty($update_fields->type)) {
        $apiresults = ["result" => "error", "message" => "Missing required fields (type, currency)"];
        return;
    }

    // find id 
    $query = Capsule::table('tblpricing');

    if (!empty($update_fields->relid))
    $query->where('relid', $update_fields->relid);   
    
    if (!empty($update_fields->type))
    $query->where('type', $update_fields->type);   

    $results = $query->get();

    $id = $results->isNotEmpty() ? $results[0]->id : null;
    $relid = $results->isNotEmpty() ? $results[0]->relid : null;
    $type = $results->isNotEmpty() ? $results[0]->type : null;

    if (!$id) {
        $apiresults = ["result" => "error", "message" => "No pricing record found with the provided criteria"];
        return;
    }

    Capsule::table('tblpricing')
        ->where('id', $id)
        ->update((array)$update_fields);

    $results = $query->get();    

    $apiresults = [
        "result" => "success",
        "id" => $id,
        "data" => $results
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
