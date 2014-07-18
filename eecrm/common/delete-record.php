<?php
/**
 * A common file to delete the record according to the respective parameters.
 * 
 */
require_once dirname(__DIR__).'/include-locations.php';
require_once $include_directory . 'define.php';
require_once dirname(__DIR__)."/include/database.php";

if (!empty($_POST)) {
    global $db;
    $response = array();
    $response['valid'] = 0;
    
    $modules = $_POST['module'];
    $field   = $_POST['field'];
    $value   = $_POST['value'];
    
    $sql = "UPDATE `"   .$modules. "` 
                SET deleted = 1 
                WHERE `".$field. "` = :".$field;
    try {
        $statement = $db->prepare($sql);
        $statement->bindValue(":$field", $value);
        $statement->execute();
        
        if ($modules == 'attachment') {
            $file = $include_directory . '../data/upload/' . md5($value);
            unlink($file);
        }
        
        $string = "Record has been deleted successfully";
        $response['valid'] = 1;
    } catch(Exception $exception) {
        $string = $exception->getMessage();
    } 
    $string = $value;
    $response['str'] = $string;
    //print_r($response); exit;
    @header("Content-type: text/json");
    $jsonResponse = json_encode($response);
    echo $jsonResponse;
}