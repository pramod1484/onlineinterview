<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Auth
 *
 * @author pramodkadam
 */
class ANSH_Auth_Adapter implements Zend_Auth_Adapter_Interface
{

    const FAILURE_IDENTITY_NOT_FOUND_MESSAGE = "Account not found or not enabled please contact administrator";
    const FAILURE_CREDENTIAL_INVALID_MESSAGE = "Password is invalid";

    /**
     *
     * @var string
     */
    protected $email;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @param email $email
     * @param email $password
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * authentication method override interface method
     * @param void 
     * @return \Zend_Auth_Result 
     */
    public function authenticate()
    {

        try {
            //initialize entity manager
            $em = \Zend_Registry::get('entityManager');
            
            //get user info by email and password provided
            $user = $em->getRepository('ANSH_Shared_Model_Entity_Users')->findOneBy(array(
                'email' => $this->email, 'isEnabled' => TRUE));
            
            //get result and send responce
            if ($user == NULL) {
                $result = $this->createResult(\Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, NULL, self::FAILURE_IDENTITY_NOT_FOUND_MESSAGE
                );
            } else {
                //get encrypted password
                $encryptedPassword = ANSH_Shared_Model_Repositaries_userRepositary::encryptPassword(
                                $this->password, $user->getPasswordSalt()
                );
                if (!($user->getPassword() == $encryptedPassword)) {
                    $result = $this->createResult(\Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, NULL, self::FAILURE_CREDENTIAL_INVALID_MESSAGE
                    );
                } else {
                    $result = $this->createResult(\Zend_Auth_Result::SUCCESS, $user->getId(), $user);
                }
            }
        } catch (Exception $e) {
            echo $result = $e->getMessage();
        }
        return $result;
        // TODO remove when server upgraded to 5.5 <
        /* finally {
          return $result;
          } */
    }

    /**
     * Factory for Zend_Auth_Result
     *
     * @param integer The Result code, see Zend_Auth_Result
     * @param \Entities\User The entity whose identifier we will use.
     * @param mixed The Message, can be a string or array
     * @return \Zend_Auth_Result
     */
    public function createResult($code, $user = NULL, $messages = array())
    {
        if (!is_array($messages)) {
            $messages = array($messages);
        }

        $identifier = NULL;
        if (!is_null($user)) {
            $identifier = $user;
        }
        return new \Zend_Auth_Result($code, $identifier, $messages);
    }

}
