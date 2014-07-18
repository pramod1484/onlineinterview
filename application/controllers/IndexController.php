<?php

class IndexController extends Zend_Controller_Action
{

    public function init ()
    {
        /* Initialize action controller here */
    }
    // forwarding request to login page
    public function indexAction ()
    {
        $this->_forward('index', 'login');
    }
}
