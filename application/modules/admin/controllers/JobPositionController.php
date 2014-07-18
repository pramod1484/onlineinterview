<?php

class Admin_JobPositionController extends Zend_Controller_Action
{

    protected $_jobPositionMapper = null;

    public $flashMessenger;
    
     /**
     * initialize jobPositionMapper,flashMessanger helper to use in entire class
     */
    public function init()
    {
        //disable layout on ajax request
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $this->_jobPositionMapper = new Admin_Model_JobPositions();
    }

    //forwart request to list action
    public function indexAction()
    {
        $this->_forward('list','job-position','admin',$this->getAllParams());
    }

    //list all job positions
    public function listAction()
    {
        $page = $this->getRequest()->getParam('page');
        $this->view->jobPositions = $this->_jobPositionMapper->getAllJobPositionData($page);
    }

    // add a job position
    public function addAction()
    {
        //initialize the form
         $this->view->form = $form = new Admin_Form_JobPosition();
        $request = $this->getRequest();
        
        //check request is by post or not
        if ($request->isPost()) {
            
            $postData = $request->getPost();
            $validData = $form->getValidValues($postData);
            
            //check posted data is valid or not
            if ($form->isValid($postData)) {
                
                $result = $this->_jobPositionMapper->save($validData);
                
                // checks job-position inserting or not
                if ($result) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'Job position added successfully!'
                            ));
                    $this->_redirect('admin/job-position/list');
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => $this->_jobPositionMapper->getErrors()
                            ));
                    $this->_redirect($request->getHeader('referer'));
                }
            }
            $form->setDefaults($validData);
        }
    }

    //edit a job position
    public function editAction()
    {
        $request = $this->getRequest(); 
        
        $positionId = $request->getParam('positionId');
        $validData = $this->_jobPositionMapper->getJobPositionById($positionId);
        
        $this->view->form = $form = new Admin_Form_JobPosition($validData);
        $form->jobPositionName->removeValidator(
                'ANSH_Resources_Validators_NoDbRecordExist');
        
        //check request is by post or not
        if ($request->isPost()) {
            $postData = $request->getPost();
            $validData = $form->getValidValues($postData);
            
            //check posted data is valid or not
            if ($form->isValid($postData)) {
                $validData['id'] = $positionId;
                $result = $this->_jobPositionMapper->save($validData);
                
                // checks job-position inserting or not
                if ($result) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'Job position updated successfully!'
                            ));
                    $this->_redirect('admin/job-position/list');
                } else {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => $this->_jobPositionMapper->getErrors()
                            ));
                    $this->_redirect($request->getHeader('referer'));
                }
            }
            $form->setDefaults($validData);
        }
    }


}







