<?php

class Admin_ReportController extends Zend_Controller_Action
{

    protected $_candidateMapper = null;

    public $flashMessenger = null;

    /**
     * initialize candidateMapper,flashMessanger helper to use in entire class
     */
    public function init()
    {
       // check ajax request then disable layout for all action
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        //initialize flash messenger for use in controller action
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        // initialize candidate mappper for use in more than 1 action
        $this->_candidateMapper = new Admin_Model_CandidateTestMapper();
    }

    //list all candidate of test given
    public function indexAction()
    {
        $review = ($this->getParam('review')) ? $this->getParam('review') : 0;
        //get candidate reviewd or all
        $this->view->candidates = $this->_candidateMapper->getAllCandidateTestResults(
                $this->getParam('page'), $review);
    }

    // get candidate marksheet
    public function getMarksheetAction()
    {
        try {
            $candidateTestId = $this->getParam('candidateTestId');
            
            $candidateTestAnswersMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
            $this->view->testResult = $candidateTestAnswersMapper->getCandidateTestResult(
                    $candidateTestId);
            $this->view->candidateDetails = $this->getCandidateDetails(
                    $candidateTestId);
            sleep(2);
        } catch (Exception $ex) {
            return $this->_helper->json($ex->getMessage());
        }
    }

    //function to get candidate info
    private function getCandidateDetails($candidateTestId)
    {
        
        $candidateMapper = new Admin_Model_CandidateTestMapper();
        return $candidate = $candidateMapper->getCatndidateTestById(
                $candidateTestId);
        sleep(2);
    }

    //update marks
    public function updateMarkAction()
    {
        try {
            $request = $this->getRequest();
            
            // allow only post request
            if ($request->isPost()) {
                $testId = $request->getParam('candidateTestId');
                $questionId = $request->getPost('questionId');
                $mark = $request->getPost('mark');
                $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
                $result = $candidateQuestionAnswerMapper->updateMarks($testId, 
                        $questionId, $mark);
                if ($result) {
                    $responce = $result;
                } else {
                    $responce = $candidateQuestionAnswerMapper->getErrors();
                }
                usleep(200);
                return $this->_helper->json($responce);
            } else {
                throw new Exception('Unauthorised');
            }
        } catch (Exception $ex) {
            return $this->_helper->json($ex->getMessage());
        }
    }

    //get candidate graffical report
    public function getCategorywiseGrafficalReportAction()
    {
        try {
            $this->_helper->layout()->disableLayout();
            $candidateTestId = $this->getParam('candidateTestId');
            
            $this->view->candidateDetails = $this->getCandidateDetails(
                    $candidateTestId);
            $candidateTestAnswersMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
            $this->view->testResult = $candidateTestAnswersMapper->getCandidateTestResult(
                    $candidateTestId);
            sleep(2);
        } catch (Exception $ex) {
            return $this->_helper->json($ex->getMessage());
        }
    }

    // get all candidate list category wise
    public function categoryWiseReportAction()
    {
        $this->view->candidates = $this->_candidateMapper->getAllCategoryWiseCandidateTestResults(
                $this->getParam('page'));
    }

    //get all candidate report position wise
    public function positionWiseReportAction()
    {
        $form = new Admin_Form_Cadidate();
        $position = $form->position->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getJobPositions('All'));
        
  
            $positionId = $this->getParam('position');
            $position->setValue($positionId);
        
        if($this->getParam('fromDate')) {
            $this->view->fromDate = $fromDate = $this->getParam('fromDate');
        }
        if($this->getParam('toDate')) {
            $this->view->toDate = $toDate = $this->getParam('toDate');          
        }
      
        //check from date and to date is valid 
        if(($this->view->fromDate  >  date('Y-m-d')) || ($this->view->toDate < $this->view->fromDate)){
            $this->view->fromDate  = $this->view->toDate = NULL;
             $this->view->errorMessage = (array(
                        'error' => 'Incorrect date range.'
                ));
        }
        
          $this->view->testCategories = $this->_candidateMapper->getTestCategoriesByPosition($positionId);
            $this->view->candidates = $this->_candidateMapper->getAllPositionWiseCandidateTestResults(
                $this->getParam('page'),0,$positionId , $this->view->fromDate ,$this->view->toDate);
        $this->view->positionDD = $position;
    }


}




