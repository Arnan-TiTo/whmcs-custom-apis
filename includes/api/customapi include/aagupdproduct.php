<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly!");
}

function update_env($vars)
{
    $fields = [];
    if (isset($vars['type'])) $fields['type'] = $vars['type'];
    if (isset($vars['gid'])) $fields['gid'] = $vars['gid'];
    if (isset($vars['name'])) $fields['name'] = $vars['name'];
    if (isset($vars['slug'])) $fields['slug'] = $vars['slug'];
    if (isset($vars['description'])) $fields['description'] = $vars['description'];
    if (isset($vars['hidden'])) $fields['hidden'] = (int)$vars['hidden'];
    if (isset($vars['showDomainOptions'])) $fields['showdomainoptions'] = $vars['showDomainOptions'];
    if (isset($vars['welcomeEmail'])) $fields['welcomeemail'] = $vars['welcomeEmail'];
    if (isset($vars['payType'])) $fields['paytype'] = $vars['payType'];
    if (isset($vars['stockControl'])) $fields['stockcontrol'] = $vars['stockControl'];
    if (isset($vars['qty'])) $fields['qty'] = $vars['qty'];
    if (isset($vars['prorataBilling'])) $fields['proratabilling'] = $vars['prorataBilling'];
    if (isset($vars['prorataDate'])) $fields['proratadate'] = $vars['prorataDate'];
    if (isset($vars['prorataChargeNextMonth'])) $fields['proratachargenextmonth'] = $vars['prorataChargeNextMonth'];
    if (isset($vars['allowQty'])) $fields['allowqty'] = $vars['allowQty'];
    if (isset($vars['subDomain'])) $fields['subdomain'] = $vars['subDomain'];
    if (isset($vars['autoSetup'])) $fields['autosetup'] = $vars['autoSetup'];
    if (isset($vars['serverType'])) $fields['servertype'] = $vars['serverType'];
    if (isset($vars['serverGroup'])) $fields['servergroup'] = $vars['serverGroup'];

    if (isset($vars['configOption1'])) $fields['configoption1'] = $vars['configOption1'];
    if (isset($vars['configOption2'])) $fields['configoption2'] = $vars['configOption2'];
    if (isset($vars['configOption3'])) $fields['configoption3'] = $vars['configOption3'];
    if (isset($vars['configOption4'])) $fields['configoption4'] = $vars['configOption4'];
    if (isset($vars['configOption5'])) $fields['configoption5'] = $vars['configOption5'];
    if (isset($vars['configOption6'])) $fields['configoption6'] = $vars['configOption6'];
    if (isset($vars['configOption7'])) $fields['configoption7'] = $vars['configOption7'];
    if (isset($vars['configOption8'])) $fields['configoption8'] = $vars['configOption8'];
    if (isset($vars['configOption9'])) $fields['configoption9'] = $vars['configOption9'];
    if (isset($vars['configOption10'])) $fields['configoption10'] = $vars['configOption10'];
    if (isset($vars['configOption11'])) $fields['configoption11'] = $vars['configOption11'];
    if (isset($vars['configOption12'])) $fields['configoption12'] = $vars['configOption12'];
    if (isset($vars['configOption13'])) $fields['configoption13'] = $vars['configOption13'];
    if (isset($vars['configOption14'])) $fields['configoption14'] = $vars['configOption14'];
    if (isset($vars['configOption15'])) $fields['configoption15'] = $vars['configOption15'];
    if (isset($vars['configOption16'])) $fields['configoption16'] = $vars['configOption16'];
    if (isset($vars['configOption17'])) $fields['configoption17'] = $vars['configOption17'];
    if (isset($vars['configOption18'])) $fields['configoption18'] = $vars['configOption18'];
    if (isset($vars['configOption19'])) $fields['configoption19'] = $vars['configOption19'];
    if (isset($vars['configOption20'])) $fields['configoption20'] = $vars['configOption20'];
    if (isset($vars['configOption21'])) $fields['configoption21'] = $vars['configOption21'];
    if (isset($vars['configOption22'])) $fields['configoption22'] = $vars['configOption22'];
    if (isset($vars['configOption23'])) $fields['configoption23'] = $vars['configOption23'];
    if (isset($vars['configOption24'])) $fields['configoption24'] = $vars['configOption24'];

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

    $fields['updated_at'] = date('Y-m-d H:i:s');

    return (object) $fields;
}

try {
    $id = (isset($vars['id']) && is_numeric($vars['id'])) ? (int)$vars['id'] : @$_REQUEST['id'];
    $update_fields = update_env(get_defined_vars());

    if (empty($id) || !is_numeric($id)) {
        $apiresults = array(
            "result" => "error",
            "message" => "Missing or invalid 'id' " .$update_fields->id." parameter"
        );
        return;
    }

    if (empty($update_fields->name) || 
        empty($update_fields->type) || 
        empty($update_fields->description) || 
        empty($update_fields->welcomeemail) || 
        empty($update_fields->paytype)) {
        $apiresults = ["result" => "error", "message" => "Missing required fields (name, type, description, welcomeEmail, payType)"];
        return;
    }

    if (empty($update_fields)) {
        $apiresults = [
            "result"  => "error",
            "message" => "No fields to update"
        ];
        return;
    }

    Capsule::table('tblproducts')
    ->where('id', $id)
    ->update((array)$update_fields);

    $apiresults = [
        "result" => "success",
        "updated_id" => $id,
        "name" => $update_fields->name
    ];

} catch (Exception $e) {
    $apiresults = ["result" => "error", "message" => $e->getMessage()];
}

?>
