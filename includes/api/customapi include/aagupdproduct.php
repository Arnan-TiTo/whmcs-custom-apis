<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];
    if (isset($vars['id'])) $fields['id'] = $vars['id'];
    if (isset($vars['type'])) $fields['type'] = $vars['type'];
    if (isset($vars['gid'])) $fields['gid'] = $vars['gid'];
    if (isset($vars['name'])) $fields['name'] = $vars['name'];
    if (isset($vars['slug'])) $fields['slug'] = $vars['slug'];
    if (isset($vars['description'])) $fields['description'] = $vars['description'];
    if (isset($vars['hidden'])) $fields['hidden'] = (int)$vars['hidden'];
    if (isset($vars['showDomainOptions'])) $fields['showdomainoptions'] = $vars['showDomainOptions'];
    if (isset($vars['welcomeEmail'])) $fields['welcomeemail'] = $vars['welcomeEmail'];
    if (isset($vars['stockControl'])) $fields['stockcontrol'] = $vars['stockControl'];
    if (isset($vars['qty'])) $fields['qty'] = $vars['qty'];
    if (isset($vars['prorataBilling'])) $fields['proratabilling'] = $vars['prorataBilling'];
    if (isset($vars['prorataDate'])) $fields['proratadate'] = $vars['prorataDate'];
    if (isset($vars['prorataChargeNextMonth'])) $fields['proratachargenextmonth'] = $vars['prorataChargeNextMonth'];
    if (isset($vars['payType'])) $fields['paytype'] = $vars['payType'];
    if (isset($vars['allowQty'])) $fields['allowqty'] = $vars['allowQty'];
    if (isset($vars['subDomain'])) $fields['subdomain'] = $vars['subDomain'];
    if (isset($vars['autoSetup'])) $fields['autosetup'] = $vars['autoSetup'];
    if (isset($vars['serverType'])) $fields['servertype'] = $vars['serverType'];
    if (isset($vars['serverGroup'])) $fields['servergroup'] = $vars['serverGroup'];

    // configOption1 - configOption24
    for ($i = 1; $i <= 24; $i++) {
        $configOption = "configOption$i";
        if (isset($vars[$configOption])) {
            $fields["configoption$i"] = $vars[$configOption];
        }
    }

    if (isset($vars['freeDomain'])) $fields['freedomain'] = $vars['freeDomain'];
    if (isset($vars['freeDomainPaymentTerms'])) $fields['freedomainpaymentterms'] = $vars['freeDomainPaymentTerms'];
    if (isset($vars['freeDomainTlds'])) $fields['freedomaintlds'] = $vars['freeDomainTlds'];
    if (isset($vars['recurringCycles'])) $fields['recurringcycles'] = $vars['recurringCycles'];
    if (isset($vars['autoTerminateDays'])) $fields['autoterminatedays'] = $vars['autoTerminateDays'];
    if (isset($vars['autoTerminateEmail'])) $fields['autoterminateemail'] = $vars['autoTerminateEmail'];
    if (isset($vars['configOptionsUpgrade'])) $fields['configoptionsupgrade'] = $vars['configOptionsUpgrade'];
    if (isset($vars['billingCycleUpgrade'])) $fields['billingcycleupgrade'] = $vars['billingCycleUpgrade'];
    if (isset($vars['upgradeEmail'])) $fields['upgradeemail'] = $vars['upgradeEmail'];
    if (isset($vars['overagesEnabled'])) $fields['overagesenabled'] = $vars['overagesEnabled'];
    if (isset($vars['overagesDiskLimit'])) $fields['overagesdisklimit'] = $vars['overagesDiskLimit'];
    if (isset($vars['overagesBwLimit'])) $fields['overagesbwlimit'] = $vars['overagesBwLimit'];
    if (isset($vars['overagesDiskPrice'])) $fields['overagesdiskprice'] = $vars['overagesDiskPrice'];
    if (isset($vars['overagesBwPrice'])) $fields['overagesbwprice'] = $vars['overagesBwPrice'];
    if (isset($vars['tax'])) $fields['tax'] = $vars['tax'];
    if (isset($vars['affiliateOneTime'])) $fields['affiliateonetime'] = $vars['affiliateOneTime'];
    if (isset($vars['affiliatePayType'])) $fields['affiliatepaytype'] = $vars['affiliatePayType'];
    if (isset($vars['affiliatePayAmount'])) $fields['affiliatepayamount'] = $vars['affiliatePayAmount'];
    if (isset($vars['order'])) $fields['order'] = $vars['order'];
    if (isset($vars['retired'])) $fields['retired'] = $vars['retired'];
    if (isset($vars['isFeatured'])) $fields['is_featured'] = $vars['isFeatured'];
    if (isset($vars['color'])) $fields['color'] = $vars['color'];
    if (isset($vars['tagLine'])) $fields['tagline'] = $vars['tagLine'];
    if (isset($vars['shortDescription'])) $fields['short_description'] = $vars['shortDescription'];

    // update timestamp
    $fields['updated_at'] = date('Y-m-d H:i:s');

    return $fields;
}

try {
    $update_fields = update_env($get_defined_vars());

    if (empty($update_fields->id) || !is_numeric($update_fields->id)) {
        $apiresults = array(
            "result" => "error",
            "message" => "Missing or invalid 'id' " .$update_fields->id." parameter"
        );
        return;
    }

    if (empty($update_fields)) {
        $apiresults = ["result" => "error", "message" => "No fields provided to update"];
        return;
    }

    $id = $update_fields->id;
    unset($update_fields['id']);

    Capsule::table('tblproducts')
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
