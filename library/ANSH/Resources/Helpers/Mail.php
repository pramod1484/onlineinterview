<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryOptions
 *
 * @author pramodkadam
 */
class ANSH_Resources_Helpers_Mail extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * holds hostname
     * @var type string 
     */
    protected $host;
    
    /**
     * holds port no for smtp protocol
     * @var type integer
     */
    protected $port;
    
    /**
     * holds mail protocol
     * @var type string
     */
    protected $connection;
    
    /**
     *
     * @var type string
     */
    protected $userName;
    
    /**
     * holds password
     * @var type string
     */
    protected $password;

    /**
     * initialize local variables
     * @param type string
     * @param type $port as integer
     * @param type $connection as string
     * @param type $username as string
     * @param type $password as string
     */
        public function __construct($host = 'mail.ansh-systems.com', 
                                    $port = 587, $connection = 'tls', 
                                    $username = 'online.interview@ansh-systems.com', 
                                    $password = 'O78iFA1Y')//'iY1HcbNK')
    {
        $this->host = $host;
        $this->port = $port;
        $this->connection = $connection;
        $this->userName = $username;
        $this->password = $password;
    }

    /**
     * return configuration for mail
     * @return type mixed array
     */
    protected function config()
    {
        return array(
            'auth' => 'login',
            'ssl' => $this->connection,
            'username' => $this->userName
            , 'password' => $this->password
            , 'port' => $this->port);
    }

    /**
     * 
     * @return \Zend_Mail_Transport_Smtp
     */
    public function setDefaultMailFunction()
    {
        $mailTransport = new Zend_Mail_Transport_Smtp($this->host, $this->config());
        Zend_Mail::setDefaultTransport($mailTransport);
        return $mailTransport;
    }

    /**
     * 
     * @param type $message as string
     * @param type $subject as string
     * @param type $to as mixed
     * @param type $file file
     * @return type boolean
     */
    public function sendEmail($message, $subject, $to, $file = NULL)
    {
        try {
            //set default mail function
            $mailTransport = $this->setDefaultMailFunction();
            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyHtml($message);
            $mail->setFrom($this->userName, 'ANSH Online Interview App');
            $mail->setReplyTo($this->userName, 'ANSH Online Interview App');
            $mail->addHeader('MIME-Version', '1.0');
            $mail->addHeader('Content-Transfer-Encoding', '8bit');
            $mail->addHeader('X-Mailer:', 'PHP/' . phpversion());
            if(is_array($to))
            {
                foreach ($to as $receipient)
                 $mail->addTo($receipient['email'],$receipient['fullName']);
            }else
            $mail->addTo($to);
            $mail->setSubject($subject);

            // if file attached then attach to mail
            if ($file != NULL) {
                // attach PDF and set MIME type, encoding and disposition data to handle PDF files
                $attachment = $mail->createAttachment($file);
                $attachment->type = 'application/pdf';
                $attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
                $attachment->encoding = Zend_Mime::ENCODING_BASE64;
                    $session = new Zend_Session_Namespace('username');

                $attachment->filename = 'marksheet_'.$session->fullName.'.pdf';
            }
            return $mail->send($mailTransport);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    /**
     * send mail to admin for password info
     * @param type $userName as string
     * @param type $password as string
     * @param type $to as string
     * @param type $toName as string
     * @param type $userType as string
     * @return type boolean
     */
    public function sendPasswordInfo($userName, $password, $to, $toName, $userType = 'Admin')
    {
        try {
            $view = Zend_Layout::getMvcInstance()->getView();
            $url = $view->serverUrl();
            if ($userType == 'Admin') {
                $message = <<<TEXT
        
Hi $toName,
<p>
Welcome to Ansh Systems, <br>
Your account is successfully created.<br>
<br>
Details:
<br><br>
URL: <a href="$url">Ansh online interview</a><br>
Name: $toName<br>
Username: $userName<br>
Password: $password<br>
User Type: $userType<br>
</p>
                    <br>
Regards,<br>
Ansh Systems


TEXT;
            } else {
                $url .=  $view->url(array('module' => 'admin', 'action' => 'list',
                        'controller' => 'candidate', 'lastweek' => 1));
                $session = new Zend_Session_Namespace('username');
                $message = <<<TEXT
          
Hi $session->fullName,
<p>

New candidate account is successfully created.<br>
<br>
Details:
<br><br>

Name: $toName<br>
Username: $userName<br>
Password: $password<br>
User Type: $userType<br>
</p>
                    <br>
Regards,<br>
Ansh Systems


TEXT;
            }
            return $this->sendEmail($message, "Online Interview - new $userType created
", $to);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
    
    /**
     * send mail to admin for test review pending
     * @param type $marklist as file
     * @param type $candidateDetails as mixed array
     * @return type
     */
    public function testReviewAlert($marklist = NULL , $candidateDetails)
    {
        try {
            $userMapper = new Admin_Model_UserMapper();
            
            $to = $userMapper->getAllUsers();
            $view = Zend_Layout::getMvcInstance()->getView();
            $url = $view->serverUrl() . $view->url(array('module' => 'admin', 'action' => 'index',
                        'controller' => 'report', 'review' => 2));
            $message = <<<TEXT
                   
Hi,
<p>
Candidate test waiting for review.<br>
Please login here to review the tests: <br>
<a href="$url">Ansh online interview</a>
</p>
                    <hr>
<p>
    Candidate Name   : {$candidateDetails->getCandidate()->getUser()->getFullName()} <br>
    Highest degree   : {$candidateDetails->getCandidate()->getDegree()} <br>
    Position applied : {$candidateDetails->getCandidate()->getJobPosition()->getPosition()} <br>
    Email            : {$candidateDetails->getCandidate()->getUser()->getEmail()} <br>
    Mobile           : {$candidateDetails->getCandidate()->getMobileNo()}
</p>
<br>
Regards,<br>
Ansh Systems


TEXT;
    
            return $this->sendEmail($message, 'Online Interview - Test Review Pending
', $to, $marklist);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

}
