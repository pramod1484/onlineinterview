<?php

class Candidate_ProfileController extends Zend_Controller_Action
{

    protected $_candidateMapper = null;

    public $flashMessenger;

    public function init ()
    {
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $this->_candidateMapper = new Admin_Model_CandidateMapper();
    }

    public function indexAction ()
    {
        // action body
    }

    public function viewAction ()
    {
        // action body
    }

    public function editAction ()
    {
        try {
            $request = $this->getRequest();
            $candidateId = Zend_Auth::getInstance()->getIdentity();
            $validCandidateData = $this->_candidateMapper->getCandidateByCandidateId(
                    $candidateId);
            $this->view->form = $form = new Candidate_Form_Profile(
                    $validCandidateData);
            if ($request->isPost()) {
                $postData = $request->getPost();
                $validCandidateData = $form->getValidValues($postData);
                if ($form->isValid($postData)) {
                    $validCandidateData['roleId'] = 2;
                    $validCandidateData['id'] = $candidateId;
                    if ($this->_candidateMapper->saveProfile(
                            $validCandidateData)) {
                        $this->_redirect('candidate/test');
                    }
                }
                $form->persistData($validCandidateData);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
