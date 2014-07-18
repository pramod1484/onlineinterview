<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


if (!defined('IN_EECRM')) {
    define('IN_EECRM',true);
}

define("ENV","local");
//define("ENV","demo");

 
// This path should be the full filesystem path to the include directory for EECRM
// include trailing slash in path
$include_directory = "/var/www/eecrm/include/";
if (ENV == 'demo') {
    $include_directory = "/home/eastern2/domains/demo9.easternenterprise.com/public_html/include/";
} 

// Report all errors except E_NOTICE
// This is the default value set in php.ini
error_reporting(E_ALL ^E_NOTICE);


//BASIC CHECKS FOR CONFIGURATION
if ($include_directory == "/full/path/to/eecrm/include/") {
    $path = realpath('..');
    $msg = "Please read the README file and configure your include-locations.php file, in directory" ." $path";
    echo $msg;
    exit;
}
