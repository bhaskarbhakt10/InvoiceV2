<?php
// config file maily for constants

if(!defined("ROOT_PATH")){
    define("ROOT_PATH",$_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/');
}
if(!defined("ROOT_URL")){
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/';
    define("ROOT_URL", $root_url);
}