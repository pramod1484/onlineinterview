<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of checkDbPassword
 *
 * @author pramodkadam
 */
class ANSH_Resources_Validators_checkDbPassword extends Zend_Validate_Abstract
{
    
     const MESSAGE = '';

    protected $_messageTemplates = array(
        self::MESSAGE => "Old password is invalid"
    );
    
    public function isValid($value)
    {
        try {
             $session = new Zend_Session_Namespace('username');
                    
            $adapter = new ANSH_Auth_Adapter($session->userName, 
                        $value);
            $result = $adapter->authenticate();
         
                if (!$result->isValid()) {
                  $this->_error(self::MESSAGE);
            return false;
                }
                return TRUE;
        } catch (Exception $exc) {
            $this->_error($exc->getMessage());
            return false;
        }
        }
    
}
