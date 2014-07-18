<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registry
 *
 * @author pramodkadam
 */
class ANSH_Resources_Plugins_Registry extends Zend_Controller_Plugin_Abstract
{

    /**
     * Pre dispatch
     *
     * @param Zend_Controller_Request_Abstract $request
     * @return void
     *
     */
    public $flashMessanger;

    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        # get application objects
        $_registry = Zend_Registry::getInstance();

        # clone objects for ease of use
        $_em = $_registry->entityManager;

        # helper we can use in all controller
        $this->flashMessanger = $_flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');

        # send to actions
        $request->setParam('_registry', $_registry);
        $request->setParam('_em', $_em);
        $request->setParam('_flashMessenger', $_flashMessenger);
    }

}
