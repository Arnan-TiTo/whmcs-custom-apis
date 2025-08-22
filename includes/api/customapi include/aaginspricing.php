<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function insert_env($vars)
{
    $array = [
        'type'         => $vars['type'] ?? 'product',
        'currency'     => $vars['currency'] ?? 1,
        'relid'        => $vars['relid'] ?? 0,
        'msetupfee'    => $vars['mSetupFee'] ?? 0.00,
        'qsetupfee'    => $vars['qSetupFee'] ?? 0.00,
        'ssetupfee'    => $vars['sSetupFee'] ?? 0.00,
        'asetupfee'    => $vars['aSetupFee'] ?? 0.00,
        'bsetupfee'    => $vars['bSetupFee'] ?? 0.00,
        'tsetupfee'    => $vars['tSetupFee'] ?? 0.00,
        'monthly'      => $vars['monthly'] ?? 0.00,
        'quarterly'    => $vars['quarterly'] ?? 0.00,
        'semiannually' => $vars['semiAnnually'] ?? 0.00,
        'annually'     => $vars['annually'] ?? 0.00,
        'biennially'   => $vars['biennially'] ?? 0.00,
        'triennially'  => $vars['triennially'] ?? 0.00,
    ];
    
    return (object)$array;

}

try {
    $post_fields = insert_env(get_defined_vars());

    if (empty($post_fields->type) || empty($post_fields->currency) || empty($post_fields->relid)) {
        $apiresults = ["result" => "error", "message" => "Missing required fields (type, currency, relid)"];
        return;
    }

    if (!is_numeric($post_fields->msetupfee) || !is_numeric($post_fields->qsetupfee) ||
        !is_numeric($post_fields->ssetupfee) || !is_numeric($post_fields->asetupfee) ||
        !is_numeric($post_fields->bsetupfee) || !is_numeric($post_fields->tsetupfee) ||
        !is_numeric($post_fields->monthly) || !is_numeric($post_fields->quarterly) ||
        !is_numeric($post_fields->semiannually) || !is_numeric($post_fields->annually) ||
        !is_numeric($post_fields->biennially) || !is_numeric($post_fields->triennially)) {
        $apiresults = ["result" => "error", "message" => "Invalid pricing values"];
        return;
    }

    $id = Capsule::table('tblpricing')->insertGetId((array)$post_fields);

    $apiresults = [
        "result" => "success",
        "id"     => $id
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
