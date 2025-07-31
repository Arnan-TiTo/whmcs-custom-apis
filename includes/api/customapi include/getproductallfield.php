<?php

use Illuminate\Database\Capsule\Manager as Capsule;

if (!defined("WHMCS")) {
    die("This file cannot be access directly!");
}

function get_env($vars)
{
    $array = array('id' => array(), 'name' => array());
    //Post CURL
    $array['id'] = $vars['id'];
    $array['gid'] = $vars['gid'];
    $array['name'] = $vars['name'];
    $array['pricing_id'] = $vars['pricing_id'];

    return (object) $array;
}

try {

    $post_fields = get_env(get_defined_vars());

    $query = Capsule::table('vw_productpricing');

    if (isset($post_fields->id))
    $query->where('id', $post_fields->id);   

     if (isset($post_fields->gid))
    $query->where('gid', $post_fields->gid);   
    
    if (isset($post_fields->name))
    $query->where('name', $post_fields->name);   

    if (isset($post_fields->pricing_id))
    $query->where('pricing_id', $post_fields->pricing_id);  

    $results = $query->get();

    if (empty($results)) {
        throw new Exception('No data found');
    }

    $apiresults = array("result" => "success", "data" => $results);


} catch (Exception $e) {
    return ["result" => "error", "message" => $e->getMessage()];
}