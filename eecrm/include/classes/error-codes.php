<?php
/*
 * Defining Error constants.
 */

// General error codes for files
define('LOCATION_NOT_WRITABLE','Destination is not writable. Please check permissions.');
define('FILE_NOT_WRITABLE','File is not writable');
define('FILE_NOT_READABLE','File is not readable');
define('FILE_EXISTS','This file is already exists.'); 

// Error codes for file upload.
define('CONTENT_TYPE_MISMATCH','Bad Form Data was recieved. Check forms encryption Type');
define('FILE_NOT_FOUND','File not found');                
define('BAD_EXTENSION','Please upload file with valid extension');                                
define('BAD_SIZE','Upload file with expected size');                                                
define('UNKNOWN_LOCATION','Destination not foud.'); 