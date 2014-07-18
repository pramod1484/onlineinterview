<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

ini_set('display_errors', 1);
error_reporting(~0);
// include the common files
require_once('include-locations.php');
require_once $include_directory.'utils-helpers.php';

//BASIC CHECKS FOR CONFIGURATION
if ($include_directory == "/full/path/to/eecrm/include/") {
    $path = realpath('..');
    $msg = "Please read the README file and configure your include-locations.php file, in directory" ." $path";
    echo $msg;
    exit;
}

if (!getSessionValue('userId')) {
    @header("Location:login.php");
    exit;
}