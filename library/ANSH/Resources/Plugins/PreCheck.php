<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Prechecking the user and added role and modules as per user login
 *
 * @author pramodkadam
 */
class ANSH_Resources_Plugins_PreCheck extends Zend_Controller_Plugin_Abstract
{

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
       if(($request->getModuleName()!= 'default') || ($request->getControllerName() != 'login')) {
                // Zend_Debug::dump($request->getModuleName());
                $authObject = Zend_Auth::getInstance();
                if (!$authObject->hasIdentity()) {
                    $request->setModuleName('default');
                    $request->setControllerName('login');
                    $request->setActionName('index');
                    $request->setParam('requestUrl', $request->getPathInfo());
                    $request->setDispatched(false);
                } else {
                    $em = Zend_Registry::get('entityManager');
                    $user = $em->getRepository('ANSH_Shared_Model_Entity_Users')->find($authObject->getIdentity()); 
                    $request->setModuleName($user->getRole()->getRoleName());
                    $request->setDispatched();
                }
        }
    }
}
