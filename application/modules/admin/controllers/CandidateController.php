<?php

/**
 * Candidate contoller for admin manage candidates view,edit delete candidates
 */

class Admin_CandidateController extends Zend_Controller_Action
{

    protected $_candidateMapper = null;

    public $flashMessenger = null;

    /**
     * initialize candidateMapper,flashMessanger helper to use in entire class
     */
    public function init()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $this->_candidateMapper = new Admin_Model_CandidateMapper();
    }

    //forward  action to list 
    public function indexAction()
    {
        $this->_forward('list');
    }

    //list all candidates
    public function listAction()
    {
        // check request for last week candidates or all candiadtes
        $fromDate = date_modify(new DateTime(), '-1 week')->format('Y-m-d');
        $toDate = date('Y-m-d');
        $this->view->fromDate = $fromDate = $this->getParam('fromDate') ? $this->getParam('fromDate') : $fromDate;
        $this->view->toDate = $toDate = $this->getParam('toDate') ? $this->getParam('toDate') : $toDate;
        
        //checks from date is not future date or from date is less than or not blank
        if(($fromDate >  date('Y-m-d')) || ($toDate < $fromDate) || $fromDate == "" || $toDate == ""){
            $fromDate = $toDate = NULL;
             $this->view->errorMessage = (array(
                        'error' => 'Incorrect date range.'
                ));
        }
        
        // get all candidates list between two dates or all
        if(($this->getParam('fromDate')  && $this->getParam('toDate')) || $this->getParam('lastweek')) 
        $this->view->candidates = $this->_candidateMapper->getAllCandidates(
                $this->getParam('page'), $fromDate." 00:00:00",$toDate." 23:59:59");
        else
            $this->view->candidates = $this->_candidateMapper->getAllCandidates(
            		$this->getParam('page'));
    }

    // add new candidate
    public function addAction()
    {
        //initialise candidate form
        $form = $this->view->form = new Admin_Form_Cadidate();
        $_request = $this->getRequest();
        
        // check request is strictly post not by other way
        if ($_request->isPost()) {
            $data = $_request->getPost();
            
            // check valid data or return to form
            if ($form->isValidPartial($data)) {
                
                // checks candidate inserting or not
                if ($result = $this->_candidateMapper->save(
                        $form->getValidValues($data))) {
                    try {
                        
                        // storing name in zend session for send mail
                        $session = new Zend_Session_Namespace('username');
                        
                        // call to custome mail helper
                        $mailTranport = new ANSH_Resources_Helpers_Mail();
                        
                        //send password info mail
                        $mailTranport->sendPasswordInfo($result->getEmail(), 
                                $result->getDecryptedPassword(), $session->userName, 
                                $result->getFullName(), 'Candidate');
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }
                    $this->flashMessenger->addMessage(
                            array(
                                    'success' => 'Candidate added successfully!',
                                    'pass' => '<h4><p>
                                    The candidate account  ' . $result->getFullName() . ' is successfully created.
                                    
                                   and email will be sent to Admin with candidate Login credentialss.
                                    </p><h4>'
                            ));
                    $this->_redirect('admin/candidate/list');
                }
                $this->view->errorMessage = (array(
                        'error' => $this->_candidateMapper->getErrors()
                ));
            }
            $form->populate($form->getValidValues($data));
        }
    }

    //edit existing candidate
    public function editAction()
    {
        try {
            $_request = $this->getRequest();
            $candidateId = $this->getParam('candidateId');
            $validCandidateData = $this->_candidateMapper->getCandidateByCandidateId(
                    $candidateId);
            
            // if not date receive reddirect to list
            if (! $validCandidateData) {
                $this->flashMessenger->addMessage(
                        array(
                                'error' => 'Candidate not exist!'
                        ));
                $this->_redirect('admin/candidate/list');
            }
            
            $form = $this->view->form = new Admin_Form_Cadidate(
                    $validCandidateData);
            
            // remove validator for email on edit 
            $form->email->removeValidator(
                    'ANSH_Resources_Validators_NoDbRecordExist');
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                $data = $_request->getPost();
                
                // check valid data or return to form
                if ($form->isValidPartial($data)) {
                    $validCandidateData = $form->getValidValues($data);
                    $validCandidateData['id'] = $candidateId;
                    
                    // checks candidate inserting or not
                    if ($this->_candidateMapper->save($validCandidateData)) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Candidate updated successfully!'
                                ));
                        $this->_redirect('admin/candidate/list');
                    } else
                        $this->view->errorMessage = (array(
                                'error' => $this->_candidateMapper->getErrors()
                        ));
                }
            }
        } catch (Exception $ex) {
             throw new Exception($ex->getMessage());
           // echo $ex->getMessage();
        }
    }

    //delete an candidate
    public function deleteAction()
    {
        try {
            $result = $this->_candidateMapper->deleteCandidateById(
                    $this->getParam('candidateId'));
            
            //checks if not deleted show errors else redirect
            if (! $result) {
                 $this->flashMessenger->addMessage(
                         array(
                                'error' => $this->_candidateMapper->getErrors()));
            } else {
                $this->flashMessenger->addMessage(
                        array(
                                'success' => $result .
                                         ' Candidate deleted successfully!'
                        ));
            }
            $this->_redirect('admin/candidate/list');
        } catch (Exception $e) {
             throw new Exception($e->getMessage());
        }
    }

    //candidate profile view
    public function profileViewAction()
    {
        try{
            $candidateId = $this->getParam('candidateId');
            
            //get candidate info by user id
            $this->view->candidateData = $this->_candidateMapper->getCandidateByCandidateId(
                    $candidateId);
            
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }
}

