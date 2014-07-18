<?php
@session_start();
/**
 * Converting array of errors into string and showing them on browser
 * 
 * @param array $errorArray
 * @return string
 */
function showError(Array $errorArray)
{
    $stringError = '';
    foreach ($errorArray as $error) {
        $stringError .= $error  ."<br/>";
    }
    
    return $stringError;
}

/**
 * Setting session value
 * 
 * @param mixed $keyIndex
 * @param mixed $value
 */
function setSessionValue($keyIndex,$value = NULL) 
{
    if(is_array($keyIndex)) {
        foreach ($keyIndex as $key => $value) {
            $_SESSION[$key] = $value;            
        }
    } else {
        $_SESSION[$keyIndex] = $value;            
    }
}

/**
 * Getting session value according to the key.
 * 
 * @param mixed $keyIndex
 * @return mixed
 */
function getSessionValue($keyIndex)
{ 
    $sessionValue = NULL;
    if(is_array($keyIndex)) {
        $sessionValue = array();
        foreach ($keyIndex as $key => $value) {
            $sessionValue[$value] = $_SESSION[$key];            
        }
    } else {
        $sessionValue = $_SESSION[$keyIndex];            
    }    
 
    return $sessionValue;
}

/**
 * Removing any session value according to the session key.
 * If $entireSession is true destroying an entire session.
 * 
 * @param mixed $keyIndex
 * @param bool $entireSession
 */
function removeSessionValue($keyIndex, $entireSession = false) 
{
    if ($entireSession) {
        @session_destroy();
        redirect('login.php');
    } if (is_array($keyIndex)) {
        foreach ($keyIndex as $key => $value) {
            unset($_SESSION[$key]);
        }
    } else {
        unset($_SESSION[$keyIndex]);
    }
}

/**
 * Redirecting an user to specific page.
 * 
 * @param string $location
 */
function redirect($location) 
{
    if (ENV == 'demo') {
        echo "<script type='text/javascript'>window.location='".BASEPATH.$location."';</script>";
    } else {
        @header("Location:".BASEPATH.$location);
    }
    exit;
}

/**
 * Add slashes to quotes to string
 * 
 * @param string $string
 * @return string
 */
function escapeString($string)
{
    return trim(addslashes($string));
}

/**
 * Removing quotes from the string to show actual quotes in string
 * 
 * @param string $string
 * @return string
 */
function sanitizeString($string)
{
    return stripslashes($string);
}

/**
 * To check wheather the user is currently logged in or not.
 * if not redirecting towards login page instead of dashboard when user clicks 
 * on the logo icon from header menu.
 */
function isValidUser() 
{
    if (getSessionValue('user') === NULL) {
        redirect('login.php');
    }  
}
 
/**
 * Get current date according to the format.
 * 
 * @param string $format
 * @return string
 */
function getFormattedDate($date = NULL, $format = "Y-m-d H:i:s") 
{
    if ($date != NULL) {
        $date = date($format,strtotime($date));
    } else {
        $date = date($format);    
    }
    return $date;
}

/**
 * Create options from specified array
 * 
 * @param array $options
 * @return string
 */
function htmlSelectOptions($options, $default = '') {
    $ret = '';
    foreach ($options as $value => $name) {
        $select = ($default == $value) ? 'selected="selected"' : '';
        $ret .= '<option ' . $select . ' value="' . $value . '">' . $name . '</option>';
    }
    return $ret;
}

/**
 * Return array of Meeting Call Status options
 * @return array 
 */
function meetingCallStatusOption() {
    return array('Planned' => 'Planned', 'Held' => 'Held', 'Not Held' => 'Not Held');
}

/**
 * Return array of Task Status options
 * @return array 
 */
function taskStatusOption() {
    return array('Not Started' => 'Not Started', 'Started' => 'Started', 'Completed' => 'Completed', 'Canceled' => 'Canceled');
}

/**
 * Return array of Priority options
 * @return array 
 */
function taskPriorityOption() {
    return array('Normal' => 'Normal', 'Low' => 'Low', 'High' => 'High', 'Urgent' => 'Urgent');
}

/**
 * Return array of Call Direction options
 * @return array 
 */
function callDirectionOption() {
    return array('Outbound' => 'Outbound', 'Inbound' => 'Inbound');
}

/**
 * Return array of Call Duration options
 * @return array 
 */
function callDurationOption() {
    return array('300' => '5m', '600' => '10m', '900' => '15m', '1800' => '30m', '2700' => '45m', '3600' => '1h', '7200' => '2h');
}

/**
 * Return array of Duration text in minutes from seconds options
 * @return array 
 */
function getDurationText($seconds) {
    $array = callDurationOption();
    return $array[$seconds];
}

function getPermissionOptions() {
    return array('all' => 'all', 'team' => 'team', 'own' => 'own', 'no' => 'no');
}
/**
 * Return username with its link
 * @param int $userId
 * @param string $firstName
 * @param string $lastName Optional
 */
function linkUserName($userId, $firstName, $lastName = '') {
    if ($firstName == 'Admin') {
        $name = 'Admin';
    } else {
        $name = '<a href="' . ADMINPATH . 'modules/users/view.php?id=' . $userId . '">';
        $name .= $firstName . (($lastName != '') ? ' ' . $lastName : '') . '</a>';
    }
    
    return $name;
}

function getPermissionText($permission) {
    $text = '';
    switch ($permission) {
        case 'all' :
            $text = '<span style="color: #00CC00;">all</span>';
            break;
        case 'team':
            $text = '<span style="color: #999900;">team</span>';
            break;
        case 'own':
            $text = '<span style="color: #CC9900;">own</span>';
            break;
        case 'no':
        default :
            $text = '<span style="color: #FF0000;">no</span>';
            break;
    }
    
    return $text;
}