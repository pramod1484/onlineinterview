<?php
/**
 * This file helps to upload file on server via ajax.
 * 
 */
require_once dirname(__DIR__).'/include/classes/FileUpload.php';

if (!empty($_FILES)) {
    $params = array('resource' => $_FILES,
                    'objectName' => 'uploadfile',
                    'extensions' => array('csv')
        );
    $uploadFile  = new FileUpload($params);
    $fileName = $uploadFile->uploadFile();
    echo "success";
    exit;
}