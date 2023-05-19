<?php
// config file maily for constants

if (!defined("ROOT_PATH")) {
    define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/');
}
if (!defined("ROOT_PATH_DB")) {
    define("ROOT_PATH_DB", $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/classes/database/database.config.php');
}
if (!defined("ROOT_PATH_DBTABLES")) {
    define("ROOT_PATH_DBTABLES", $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/classes/database/database.tables.php');
}
if (!defined("ROOT_PATH_CLASS")) {
    define("ROOT_PATH_CLASS", $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/classes/classes/');
}
if (!defined("ROOT_PATH_ACTION") || !defined("ROOT_URL_ACTION")) {
    define("ROOT_PATH_ACTION", $_SERVER['DOCUMENT_ROOT'] . '/invoiceV2/classes/actions/');
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/classes/actions/';
    define("ROOT_URL_ACTION", $root_url);
}
if (!defined("ROOT_URL")) {
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/';
    define("ROOT_URL", $root_url);
}
if (!defined("NAVIGATION_URL")) {
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/invoice/index.php?page=';
    define("NAVIGATION_URL", $root_url);
}
if (!defined("ASSETS_URL")) {
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/assets/';
    define("ASSETS_URL", $root_url);
}
if (!defined("ASSETS_HEADER_FOOTER")) {
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/assets/images/header-footer';
    define("ASSETS_HEADER_FOOTER", $root_url);
}
if (!defined("LOGO")) {
    $root_url = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/invoiceV2/assets/images/header-footer/NUIT.svg';
    define("LOGO", $root_url);
}



//timezone
if(!defined('TIMEZONE_IN')){
    define('TIMEZONE_IN','Asia/Kolkata');
}
//pdf images path 
if(!defined('PDF_IMAGES')){
    $pdf_images = ROOT_URL . 'assets/images/pdf/';
    define('PDF_IMAGES',$pdf_images);
}