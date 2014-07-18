<?php
/**
 * Login screen server screept.
 * Allowing user to access system depends on valid username and password.
 * 
 */

require_once 'include-locations.php';

require_once $include_directory . 'define.php';
require_once $include_directory . 'validation.php';
require_once $include_directory . 'utils-helpers.php';
require_once $include_directory . 'database.php';
require_once $include_directory . 'utils-login.php';
require_once $include_directory . 'utils-users-efforts.php';

if (!empty($_POST)) {
    
    // For necessary validations before executing the query
    $array = array('method' => 'POST',
                   'rules'  => array('username' => array('required'=> true), 'password' => array('required'=> true)),
                   'messages' => array('username' => array('required' => 'Please enter username'),'password' => array('required' => 'Please enter password')) 
             );
    $response = Validation::_initialize($array, $_POST);
    
    // if errors are there showing them to user
    if (!$response['valid']) { 
        setSessionValue('errorMessage', showError($response));
        redirect('login.php');
    } else {
        global $db;
       // if no errors fetch record according to the username and password.
       $username = escapeString($_POST['username']);
       $password = md5(escapeString($_POST['password']));
       
       // executing query against the DB
       $stmt = $db->prepare('SELECT * FROM users 
                                WHERE user_name = :username 
                                AND   password = :password');
       
       $stmt->execute(array(":username" => $username, ":password" => $password));
       $columnCount = $stmt->columnCount();

       // if records are there then saving values in session.
       if ($columnCount > 0) {
           try {
                $record = $stmt->fetch(PDO::FETCH_ASSOC);
                $currentDate = getFormattedDate();
                //check is entry is present for user for todays date. 
                $userLoggedIn = getUsersLoginDetailsByDate($record['id'], getFormattedDate(NULL,"Y-m-d"));
                if (count($userLoggedIn) > 0) {
                  // adding for login details
                    $loginData = array();
                    $loginData['login_id'] = $record['id'];
                    $loginData['signin_time'] = $currentDate;
                    $loginData['signout_time'] = $currentDate;
                    $loginData['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $loginData['status'] = 1;
                    
                    $isValidLoginAgain = addUsersLoginDetails($loginData);                      
                    
                    // get users efforts record
                    $effortId = getUsersEffortsId($record['id'],getFormattedDate(NULL,"Y-m-d"));                    
                } else {
                    // adding record in login master table 
                    $data = array();
                    $data['login_id'] = $record['id'];
                    $data['number_of_breaks'] = 0;
                    $data['login_date'] = getFormattedDate(NULL,"Y-m-d");
                    $data['first_singin_time'] = $currentDate;
                    $data['last_sign_of_time'] = $currentDate;                
                    
                    $validMasterLogin = makeUserLogin($data);
                    
                  // adding for login details
                    $loginData = array();
                    $loginData['login_id'] = $record['id'];
                    $loginData['signin_time'] = $currentDate;
                    $loginData['signout_time'] = $currentDate;
                    $loginData['ip_address'] = $_SERVER['REMOTE_ADDR'];
                    $loginData['status'] = 1;

                    $validLogin = addUsersLoginDetails($loginData);      
                    
                    // adding users entry in the users efforts table
                    $usersEfforts = array();
                    $usersEfforts['user_id'] = $record['id'];
                    $usersEfforts['efforts_date'] = getFormattedDate(NULL,"Y-m-d");
                    
                    $effortId = addUsersEfforts($usersEfforts);
                }
                
                $isValid = $validLogin = $validMasterLogin;
                
                if ($isValid !== NULL || $isValidLoginAgain != NULL) {
                    $setValues = array('is_admin' => $record['is_admin'],
                                       'username' => $record['user_name'],
                                       'firstName' => $record['first_name'],
                                       'lastName' => $record['last_name'],
                                       'teamId' => $record['default_team_id'],
                                       'user' => $record['id'],
                                       'signInTime' => $currentDate,
                                       'effortId' => $effortId
                         );
                    // initializing session for user.
                    setSessionValue($setValues);                    
                    //redirecting to appropriate page.
                    redirect('dashboard.php');
                } 
           } catch (Exception $exception) {
               echo $exception->getMessage();
           }
       } else {
           // error present redirecting to login page again.
           setSessionValue('errorMessage',showError(NO_VALID_ACCOUNT));
           redirect('login.php');
       }
    }    
} else {
   // error present redirecting to login page again.
   redirect('login.php');
}