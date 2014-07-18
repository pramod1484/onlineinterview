<?php
$protocol = "http://";
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
    $protocol = "https://";
}

$baseUrl = $protocol . $_SERVER['SERVER_NAME'] . "/eecrm/";
if (ENV == 'demo') {
    $baseUrl = $protocol . $_SERVER['SERVER_NAME'] . "/";
}

define('BASEPATH', $baseUrl);
define('ADMINPATH', $baseUrl.'administration/');
define('IMAGEPATH', $baseUrl."images/");

//Current Module
define('MODULE', basename(dirname($_SERVER['PHP_SELF'])));

// Maximum rows to show
define('MAX_ROWS', 10);

// ERROR MESSAGES
define("NO_VALID_ACCOUNT",'No account found with these credentials. Please enter valid credentials');
