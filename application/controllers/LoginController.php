<?php
/**
 * login controller for autheticate user
 */
class LoginController extends Zend_Controller_Action
{

    /**
     * login and authorized user as per their role
     */
    public function indexAction ()
    {
        $this->view->layout()->setLayout('login-layout');
        $requestUrl = $this->getParam('requestUrl');
        $this->view->loginForm = $form = new Application_Form_Login($requestUrl);
        if ($this->getRequest()->isPost()) {
            $data = $this->getAllParams();
            
            /*
             * you should really validate that they submitted all the required
             * fields. however for the sake of this example, I won't do that.
             */
            if ($form->isValid($data)) {
                $adapter = new ANSH_Auth_Adapter($this->_getParam('email'), 
                        $this->_getParam('password'));
                $result = \Zend_Auth::getInstance()->authenticate($adapter);
                
                if ($result->isValid()) {
                    $responce = array_shift($result->getMessages());
                    $session = new Zend_Session_Namespace('username');
                    $session->fullName = $responce->getFullName();
                    $session->userName = $responce->getEmail();
                    $this->_redirect(
                            ($data['requestUrl'] != NULL) ? $data['requestUrl'] : $responce->getRole()
                                ->getRoleName());
                } else {
                    $this->view->message = implode(' ', $result->getMessages());
                }
            }
            
            $form->populate($form->getValidValues($data));
        }
    }
    
    // log out user
    public function logOutAction ()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('login');
    }
}
