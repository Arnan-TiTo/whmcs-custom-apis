<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function insert_env($vars)
{
    $array = [
        'id'                    => $vars['id'] ?? 0,
        'type'                  => $vars['type'] ?? 'other',
        'gid'                   => $vars['gid'] ?? 0,
        'name'                  => $vars['name'] ?? null,
        'slug'                  => $vars['slug'] ?? '',
        'description'           => $vars['description'] ?? '',
        'hidden'                => isset($vars['hidden']) ? (int)$vars['hidden'] : 0,
        'showdomainoptions'     => $vars['showDomainOptions'] ?? 0,
        'welcomeemail'          => $vars['welcomeEmail'] ?? '',
        'stockcontrol'          => $vars['stockControl'] ?? 0,
        'qty'                   => $vars['qty'] ?? 0,
        'proratabilling'        => $vars['prorataBilling'] ?? 0,
        'proratadate'           => $vars['prorataDate'] ?? 0,
        'proratachargenextmonth'=> $vars['prorataChargeNextMonth'] ?? 0,
        'paytype'               => $vars['payType'] ?? 'onetime',
        'allowqty'              => $vars['allowQty'] ?? 0,
        'subdomain'             => $vars['subDomain'] ?? '',
        'autosetup'             => $vars['autoSetup'] ?? '',
        'servertype'            => $vars['serverType'] ?? '',
        'servergroup'           => $vars['serverGroup'] ?? 0,
        'configoption1'         => $vars['configOption1'] ?? '',
        'configoption2'         => $vars['configOption2'] ?? '',
        'configoption3'         => $vars['configOption3'] ?? '',
        'configoption4'         => $vars['configOption4'] ?? '',
        'configoption5'         => $vars['configOption5'] ?? '',
        'configoption6'         => $vars['configOption6'] ?? '',
        'configoption7'         => $vars['configOption7'] ?? '',
        'configoption8'         => $vars['configOption8'] ?? '',
        'configoption9'         => $vars['configOption9'] ?? '',
        'configoption10'        => $vars['configOption10'] ?? '',
        'configoption11'        => $vars['configOption11'] ?? '',
        'configoption12'        => $vars['configOption12'] ?? '',
        'configoption13'        => $vars['configOption13'] ?? '',
        'configoption14'        => $vars['configOption14'] ?? '',
        'configoption15'        => $vars['configOption15'] ?? '',
        'configoption16'        => $vars['configOption16'] ?? '',
        'configoption17'        => $vars['configOption17'] ?? '',
        'configoption18'        => $vars['configOption18'] ?? '',
        'configoption19'        => $vars['configOption19'] ?? '',
        'configoption20'        => $vars['configOption20'] ?? '',
        'configoption21'        => $vars['configOption21'] ?? '',
        'configoption22'        => $vars['configOption22'] ?? '',
        'configoption23'        => $vars['configOption23'] ?? '',
        'configoption24'        => $vars['configOption24'] ?? '',
        'freedomain'            => $vars['freeDomain'] ?? '',
        'freedomainpaymentterms'=> $vars['freeDomainPaymentTerms'] ?? '',
        'freedomaintlds'        => $vars['freeDomainTlds'] ?? '',
        'recurringcycles'       => $vars['recurringCycles'] ?? '',
        'autoterminatedays'     => $vars['autoTerminateDays'] ?? 0,
        'autoterminateemail'    => $vars['autoTerminateEmail'] ?? '',
        'configoptionsupgrade'  => $vars['configOptionsUpgrade'] ?? '',
        'billingcycleupgrade'   => $vars['billingCycleUpgrade'] ?? '',
        'upgradeemail'          => $vars['upgradeEmail'] ?? '',
        'overagesenabled'       => $vars['overagesEnabled'] ?? 0,
        'overagesdisklimit'     => $vars['overagesDiskLimit'] ?? 0,
        'overagesbwlimit'       => $vars['overagesBwLimit'] ?? 0,
        'overagesdiskprice'     => $vars['overagesDiskPrice'] ?? 0.0000,
        'overagesbwprice'       => $vars['overagesBwPrice'] ?? 0.0000,
        'tax'                   => $vars['tax'] ?? 0,
        'affiliateonetime'      => $vars['affiliateOneTime'] ?? 0,
        'affiliatepaytype'      => $vars['affiliatePayType'] ?? '',
        'affiliatepayamount'    => $vars['affiliatePayAmount'] ?? 0.00,
        'order'                 => $vars['order'] ?? 0,
        'retired'               => $vars['retired'] ?? 0,
        'is_featured'           => $vars['isFeatured'] ?? 0,
        'color'                 => $vars['color'] ?? '',
        'tagline'               => $vars['tagLine'] ?? '',
        'short_description'     => $vars['shortDescription'] ?? '',
        'created_at'            => $vars['createdAt'] ?? date('Y-m-d H:i:s'),
        'updated_at'            => $vars['updatedAt'] ?? date('Y-m-d H:i:s'),
    ];

    return (object)$array;
}

try {
    $post_fields = insert_env(get_defined_vars());  

    if (empty($post_fields->name) || empty($post_fields->type)) {
        $apiresults = ["result" => "error", "message" => "Missing required fields (name, type)"];
        return;
    }

    $id = Capsule::table('tblproducts')->insertGetId((array)$post_fields);

    $apiresults = [
        "result" => "success",
        "id"     => $id,
        "name"   => $post_fields->name
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
