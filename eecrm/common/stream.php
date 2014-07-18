<?php
require_once dirname(__DIR__).'/include-locations.php';
require_once $include_directory . 'define.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'utils-users.php';
require_once $include_directory . 'utils-history.php';
require_once $include_directory . 'utils-stream.php';
global $db;

$data = json_decode(sanitizeString($_POST['info']), true);
//print_r($data); exit;
$entity = sanitizeString($data['entity']);
$entityId = sanitizeString($data['entityId']);
$action = sanitizeString($data['action']);
$entityType = '';

switch ($entity) {
    case 'opportunities' : $entityType = 'Opportunity';
        break;
    case 'leads' : $entityType = 'Lead';
        break;
}

$response = array('valid' => 0, 'message' => '', 'html' => '', 'error' => 0, 'errorMessage' => '');

if ($action == 'add') {
    // Add data to history
    $historyData = array();
    $historyData['entity_id'] = $entityId;
    $historyData['user_id'] = getSessionValue('user');
    $historyData['changeType'] = 'Post';
    $historyData['remark'] = sanitizeString($data['remark']);
    $historyData['action_date'] = getFormattedDate();
    $historyData['entity_type'] = $entityType;
    //Add history. If history inserted successfully get new html for stream
    $historyId = addHistory($historyData);
    if ($historyId !== NULL) {
        // If files are attached insert update corresponding file ids
        if (isset($data['files']) && $data['files'] != '') {
            $files = explode(',', $data['files']);
            foreach ($files as $file) {
                if ($file != '') {
                    $sql = "UPDATE `attachment` SET savedName = '" . md5($file) . "',
                            created_by_id = " . getSessionValue('user') . ",
                            parent_id = '$historyId', parent_type = 'history'
                            WHERE id = :file";
                    $statement = $db->prepare($sql);
                    $statement->bindValue(":file", $file);
                    $statement->execute();
                }
            }
        }
        $streamHtml = getStreamHtml($entityId, $entityType);
        $response['valid'] = 1;
        $response['message'] = 'Posted';
        $response['html'] = $streamHtml;
    } else {
        $response['error'] = 1;
        $response['errorMessages'] = 'Error';
    }
    
} elseif ($action == 'get') {
        $start = $data['start'];
        $streamHtml = getStreamHtml($entityId, $entityType, $start);
        $response['valid'] = 1;
        $response['html'] = $streamHtml;
}

@header("Content-type: text/json");
$jsonResponse = json_encode($response);
echo $jsonResponse;
?>
