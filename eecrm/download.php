<?php
require_once('include-locations.php');
require_once $include_directory . 'define.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-helpers.php';

if ($_GET['file'] && $_GET['file'] != '') {
    $file = escapeString($_GET['file']);
    $statement = $db->prepare("SELECT id, name, size, type, savedName FROM attachment 
                                   WHERE md5(id) = :file");
    $statement->bindValue(":file", $file);
    $statement->execute();
    if ($statement->rowCount() > 0) {
        $file = $statement->fetch(PDO::FETCH_OBJ);
        //echo BASEPATH . 'data/upload/' . $file->savedName; exit;
        header('Content-Description: File Transfer');
        header('Content-Type: ' . $file->type);
        header('Content-Disposition: attachment; filename="' . basename($file->name) . '"'); //<<< Note the " " surrounding the file name
        header('Content-Transfer-Encoding: binary');
        header('Connection: Keep-Alive');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . $file->size);
        readfile(BASEPATH . 'data/upload/' . $file->savedName);
    }
}
?>
