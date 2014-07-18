<?php

/**
 * Technology controller for manage technology for test add.
 */
class Admin_TechnologyController extends Zend_Controller_Action
{

    protected $_technologyMapper;

    public $_flashMessegner;

    /**
     * initialize technologyMapper,flashMessanger helper to use in entire class
     */
    public function init ()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $this->_technologyMapper = new Admin_Model_TechnologyMapper();
    }

    public function indexAction ()
    {
        // action body
    }
    
    // list out all technologies defined
    public function listAction ()
    {
        $this->view->technologies = $this->_technologyMapper->getAllTechnologyData(
                $this->getParam('page'));
    }
    
    // add a new technology
    public function addAction ()
    {
        $this->view->form = $form = new Admin_Form_TechnologyForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $request->getPost();
            $validData = $form->getValidValues($postData);
            
            if ($form->isValid($postData)) {
                $result = $this->_technologyMapper->save($validData);
                
                // checks technology inserting or not
                if ($result) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'Technology added successfully!'
                            ));
                    $this->_redirect('admin/technology/list');
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => $this->_technologyMapper->getErrors()
                            ));
                    $this->_redirect($request->getHeader('referer'));
                }
            }
            $form->setDefaults($validData);
        }
    }
    
    // edit existing technology
    public function editAction ()
    {
        $request = $this->getRequest();
        $technologyId = $request->getParam('technologyId');
        $validData = $this->_technologyMapper->getTechnologyById($technologyId);
        $this->view->form = $form = new Admin_Form_TechnologyForm($validData);
        $form->technologyName->removeValidator(
                'ANSH_Resources_Validators_NoDbRecordExist');
        
        //check request is post or not
        if ($request->isPost()) {
            $postData = $request->getPost();
            $validData = $form->getValidValues($postData);
            
            if ($form->isValid($postData)) {
                // set id in data from url
                $validData['id'] = $technologyId;
                $result = $this->_technologyMapper->save($validData);
                
                // checks technology inserting or not
                if ($result) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'Technology updated successfully!'
                            ));                    
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => $this->_technologyMapper->getErrors()
                            ));
                }
                $this->_redirect('admin/technology/list');
            }
            $form->setDefaults($validData);
        }
    }

    //delete a technology
    public function deleteAction ()
    {
        try {
            $result = $this->_technologyMapper->deleteTechnology(
                    $this->getParam('technologyId'));
            if (! $result) {
                $this->flashMessenger->addMessage(
                         array(
                                'error' => $this->_technologyMapper->getErrors()));
            } else {
                $this->flashMessenger->addMessage(
                        array(
                                'success' => $result .
                                         ' Technology deleted successfully!'
                        ));
            }
             $this->_redirect('admin/technology/list');
            
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
