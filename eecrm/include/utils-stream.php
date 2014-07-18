<?php
require_once 'database.php';
require_once 'utils-history.php';
require_once 'utils-call_status.php';
require_once 'utils-status.php';
require_once 'utils-stages.php';

/**
 * Get Stream HTML from history
 * @param int $entityId Entity Id
 * @param string $entityType Ex. Lead/Opportunity
 * @param int $start Starting from
 * @param int $limit 
 * @return string
 */
function getStreamHtml($entityId, $entityType, $start = 0, $limit = 5) {
    $streams = getHistory($entityId, $entityType, $start, ($limit+1));
    $html = '';
    if (count($streams) > 0) :
        $html = '<div class="list list-expanded">
                <ul class="list-group">';
        $count = 0;        
        foreach ($streams as $stream) :
            $count++;
            if ($count > $limit) {
                break;
            }
            $html .= '<li data-id="' . $stream['history_id'] . '" class="list-group-item">
                <div>
                   ' . getStreamLabel($stream['changeType'], $stream['change_param'], $stream['entity_type']) . '
                   <span class="text-muted">' . linkUserName($stream['user_id'], $stream['first_name'], $stream['last_name']) . '
                       ' . getStreamText($stream['changeType'], $stream['change_param'], $stream['entity_type']) . '
                   </span>
                </div>';
            if ($stream['remark'] != '') {
                $html .= '<div>
                            <span class="cell cell-message">' . $stream['remark'] . '</span>
                          </div>';
            }
            
            $html .= getFilesHtml($stream['history_id']);
            
            $html .= '<div>
                   <span class="text-muted small">' . getFormattedDate($stream['change_date'], 'm/d/Y H:i') . '</span>
                </div>
             </li>';
        endforeach;
        $html .= '</ul>';
        if ($count > $limit) {
            $html .= '<div class="show-more" data-start="' . ($start + $limit) .'">
                        <a type="button" href="javascript:" class="btn btn-default btn-block" data-action="showMore">Show more</a>
                      </div>';
        }
        $html .= '</div>';
    endif;

    return $html;
}


/**
 * Creates Label for stream
 * @param string $changeType
 * @param int $changeParam
 * @param string $entityType
 * @return type
 */
function getStreamLabel($changeType, $changeParam, $entityType) {
    $lable = '';
    switch ($changeType) {
        case 'Create':
                if ($entityType == 'Opportunity') {
                    $lable = '<span class="label label-success">Converted</span>';
                } else {
                    $lable = '<span class="label label-primary">New</span>';
                }
                break;
                case 'Call Status':
                $lable = getCallStatusDetails('status_name',$changeParam);
                $lable = ($lable == '') ? '' : '<span class="label label-primary">' . $lable . '</span>';
                break;
        case 'Status':
                $lable = getStatusDetails('status_name',$changeParam);
                $lable = ($lable == '') ? '' : '<span class="label label-primary">' . $lable . '</span>';
                break;
        case 'Stage':
                $lable = getStageDetails('stage_name',$changeParam);
                $lable = ($lable == '') ? '' : '<span class="label label-default">' . $lable . '</span>';
                break;
        default : 
                break;
    }
    
    return $lable;
}

/**
 * Creates Stream Text
 * @param type $changeType
 * @param type $changeParam
 * @param type $entityType
 * @return string
 */
function getStreamText($changeType, $changeParam, $entityType) {
    $text = '';
    switch ($changeType) {
        case 'Create':
                if ($entityType == 'Opportunity') {
                    $text = "Converted Lead to this $entityType";
                } else {
                    $text = "Created this $entityType";
                }
                break;
                case 'Call Status':
        case 'Status':
        case 'Stage':
                $text = "updated $entityType $changeType";
                break;
        case 'Post':
                $text = "Posted";
                break;
        case 'Assign':
                $user = getUserName($changeParam); //Get User name of $changeParam
                $text = "assigned this $entityType to " . linkUserName($changeParam, $user);
                break;
        default : 
                break;
    }
    
    return $text;
}

function getFilesHtml($historyId) {
    global $db;
    $html = '';
    try {
        $statement = $db->prepare("SELECT id, savedName, name FROM attachment 
                                   WHERE parent_id = $historyId 
                                   AND deleted = 0");
        $statement->execute();
        if ($statement->columnCount() > 0) {
            $details = $statement->fetchAll(PDO::FETCH_ASSOC);
            $filesHtml = '';
            foreach ($details as $files) {
                if ($filesHtml != '') {
                    $filesHtml = $filesHtml . ', ';
                }
                $filesHtml .= '<span class="glyphicon glyphicon-paperclip small"></span> 
                           <a target="_blank" href="' . BASEPATH . 'download.php?file=' . $files['savedName']. '">' .$files['name']. '</a>';
            }
            $html =  '<div>		
		<span class="cell cell-attachments">
                    ' . $filesHtml . '
                </span>
            </div>';
        }
    } catch (Exception $e) {
        $html = $exc->getMessage();
    }
    
    return $html;
}
?>
