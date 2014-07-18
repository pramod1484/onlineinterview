<?php

/**
 * User controller to manage admin users
 */

class Admin_UserController extends Zend_Controller_Action
{

    protected $_userMapper = null;

    public $flashMessenger = null;

    /**
     * initialize userMapper,flashMessanger helper to use in entire class
     */
    public function init()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $this->_userMapper = new Admin_Model_UserMapper();
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    /**
     * add new admin user in database
     */
    public function addAction()
    {
        // initialize form
        $form = $this->view->userForm = new Admin_Form_UserPartial();
        $_request = $this->getRequest();
        
        // check request is strictly post not by other way
        if ($_request->isPost()) {
            $data = $_request->getPost();
            
            // check valid data or return to form
            if ($form->isValidPartial($data)) {
                
                // checks user inserting or not
                if ($result = $this->_userMapper->save(
                        $form->getValidValues($data))) {
                    try {
                        $session = new Zend_Session_Namespace('username');
                        $mailTranport = new ANSH_Resources_Helpers_Mail();
                        $mailTranport->sendPasswordInfo($result->getEmail(), 
                                $result->newpassword, $result->getEmail(), 
                                $result->getFullName());
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'User added successfully!',
                                    'pass' => ' <p><h4>The admin account  ' .
                                             $result->getFullName() . ' is successfully created.<br><br>

An email will be sent to the ' .
                                             $result->getEmail() . ' with login details.
</h4></p>'
                            ));
                    
                    $this->_redirect('admin/user/list');
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => $this->_userMapper->getErrors()
                            ));
                }
            }
            $form->populate($form->getValidValues($data));
        }
    }

    // edit an user
    public function editAction()
    {
        // get userdata from database
        $userId = $this->getParam('userId');
        $validUserData = (array) $this->_userMapper->getUserById($userId);
        
        // initialise the form
        $form = $this->view->userForm = new Admin_Form_UserPartial();
        $form->email->removeValidator(
                'ANSH_Resources_Validators_NoDbRecordExist');
        $_request = $this->getRequest();
        
        // check request is strictly post not by other way
        if ($_request->isPost()) {
            
            $data = $_request->getPost();
            $validUserData = $form->getValidValues($data);
            
            // check valid data or return to form
            if ($form->isValid($data)) {
                // insert id in array
                $validUserData['id'] = $userId;
                
                // check user updating or not
                if ($this->_userMapper->isValidPartial($validUserData)) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'User updated successfully!'
                            ));
                    $this->_redirect('admin/user/list');
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => 'Something goes wrong please try again!'
                            ));
                    $this->_redirect($_request->getHeader('referer'));
                }
            }
        }
        // populate form data from database or by validation
        $form->populate($validUserData);
    }

    //delete an user
    public function deleteAction()
    {
        $_request = $this->getRequest();
        $userId = $this->getParam('userId');
        
        // checks current admin user and requested delete user
        if (Zend_Auth::getInstance()->getIdentity() == $userId) {
            $this->flashMessenger->addMessage(
                    array(
                            'error' => 'You can not delete own account from here!'
                    ));
            $this->_redirect($_request->getHeader('referer'));
        }
        
        // check user deleting or not
        if ($this->_userMapper->deleteUserById($userId)) {
            $this->flashMessenger->addMessage(
                    array(
                            'success' => 'User deleted successfully!'
                    ));
            $this->_redirect('admin/user/list');
        } else {
            $this->flashMessenger->addMessage(
                    array(
                            'error' => 'Something goes wrong please try again!'
                    ));
            $this->_redirect($_request->getHeader('referer'));
        }
    }

    //list all users
    public function listAction()
    {
        $this->view->users = $this->_userMapper->getAllUsers(
                $this->_getParam('page'));
    }

    //change password admin
    public function changePasswordAction()
    {
        // initialise the form
        $form = $this->view->userForm = new Admin_Form_UserPartial();
        $_request = $this->getRequest();
        
        // check request is strictly post not by other way
        if ($_request->isPost()) {
            
            $data = $_request->getPost();
           
            $validUserData = $form->getValidValues($data);
         
            // check valid data or return to form
            if ($form->isValidPartial($data)) {
                // insert id in array
                $validUserData['id'] = Zend_Auth::getInstance()->getIdentity();
                // check user updating or not
                if ($result = $this->_userMapper->save($validUserData)) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'Password updated successfully!'
                            ));
                    $this->view->message = 'Password updated successfully!';
                    $this->_forward('log-out','login','default');
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => $this->_userMapper->getErrors()
                            ));
                    $this->_redirect($_request->getHeader('referer'));
                }
            }
             // populate form data from database or by validation
             $form->populate($validUserData);
        }             
    }
}

