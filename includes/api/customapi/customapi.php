<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function customapi_config() {
    return [
        'name'        => 'Custom API',
        'description' => 'Provides custom API endpoints',
        'version'     => '1.0',
        'author'      => 'License TV',
    ];
}
