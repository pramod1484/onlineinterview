<?php

class Candidate_TestController extends Zend_Controller_Action
{

    private $testId = null;

    protected $candidateQuestionAnswerMapper = null;

    protected $flashMessenger = null;

    public function init()
    {
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        // TODO remove on production
        // if(!isset($this->testId) && $this->testId!==NULL){
        $cadidateTest = $this->getCandidateTestInfo();
        if (! $cadidateTest) {
            $this->flashMessenger->addMessage(
                    array(
                            'error' => 'Test is not assigned to you contact administrator!'
                    ));
            
            $this->redirect('profile/edit');
        }
        $this->view->candidateInfo = $cadidateTest;
        $this->testId = $cadidateTest->getTest()->getId();
        if (! isset($this->candidateQuestionAnswerMapper))
            $this->candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper(
                    $this->testId);
        // }
    }

    public function indexAction()
    {
        $candidateMapper = new Admin_Model_CandidateMapper();
        $candidateDetails = $candidateMapper->getCandidateByCandidateId(
                Zend_Auth::getInstance()->getIdentity());
        if ($candidateDetails->getDegree() == '' ||
                 $candidateDetails->getExperience() == '') {
            $this->redirect('profile/edit');
        }
        $this->view->candidateTestCategories = $this->candidateQuestionAnswerMapper->getCandidateTestCategories();
    }

    private function getCandidateTestInfo()
    {
        $test = new Admin_Model_CandidateTestMapper();
        $candidateModel = new Admin_Model_CandidateMapper();
        $candidateId = $candidateModel->getCandidateByCandidateId(
                Zend_Auth::getInstance()->getIdentity());
        return $test->getCatndidateTestByCandidateId($candidateId->getId());
    }

    public function startAction()
    {
        try {
            $cadidateTest = $this->getCandidateTestInfo();
            
            if (($cadidateTest->getStartTime() != '') &&
                     ($cadidateTest->getEndTime() != '')) {
                $this->view->message = 'You have already given this test.';
                $this->_forward('thank-you');
            }
            $this->view->candidateTestCategories = $this->candidateQuestionAnswerMapper->getCandidateTestCategories();
            $this->view->categoryId = $this->view->candidateTestCategories[0];
            $this->view->firstQuestion = $this->candidateQuestionAnswerMapper->generateQuestionsFromCategories(
                    $this->view->categoryId['id'], $cadidateTest->getId());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getCurrentTestCategories()
    {
        return $this->_testCategories;
    }

    private function questionDisplay($request)
    {
        $this->candidateQuestionAnswerMapper->getCandidateQuestionAnswerByTestIdAndQuestionId(
                $this->testId, $request);
        $question = $this->candidateQuestionAnswerMapper->getQuestions();
        return Zend_Json::encode($question);
    }

    public function ajaxQuestionCallAction()
    {
        $request = $this->getParam('question');
        return $this->_helper->json($this->questionDisplay($request));
    }

    public function getQuestionAction()
    {
        $this->_helper->layout->disableLayout();
        $nextQuestionId = $this->getRequest()->getParam('nextRow');
        $questionId = $this->getRequest()->getParam('questionId');
        $categoryId = $this->view->categoryId = $this->getParam('category');
        $cadidateTest = $this->getCandidateTestInfo();
        
        // if questionId present it update existing question
        if ($questionId) {
            $answersData['id'] = $questionId;
            $answersData['answers'] = serialize(
                    $this->getRequest()->getParam('answer'));
            $answersData['timeTaken'] = $this->getDateDiff(
                    $this->getRequest()
                        ->getParam('startTime'), new DateTime());
            $this->candidateQuestionAnswerMapper->save($answersData);
        }
        
        if (($this->getRequest()->getParam('end')) &&
                 $this->getRequest()->getParam('end') == true) {
            if (! $this->candidateQuestionAnswerMapper->setTimeUp(
                    $cadidateTest->getId(), $questionId))
                return $this->_helper->json(
                        $this->candidateQuestionAnswerMapper->getErrors());
        }
        // updating candidates test start time
        if ($this->getRequest()->getParam('testStartTime')) {
            $cadidateTest = $this->getCandidateTestInfo();
            $candidateTestMapper = new Admin_Model_CandidateTestMapper();
            $candidateTestMapper->setTestStartTime($cadidateTest->getId(), 
                    $this->getRequest()
                        ->getParam('testStartTime'));
        }
        
        // checking all categories and tests are finished
        if ($categoryId == "" && ($nextQuestionId == '')) {
            $candidateTestMapper = new Admin_Model_CandidateTestMapper();
            $candidateTestMapper->setTestEndTimeandStatus(
                    $cadidateTest->getId());
            $this->_helper->json(1);
        }
        
        // generating next categories questions
        if ($nextQuestionId != '') {
            $this->view->questions = $this->candidateQuestionAnswerMapper->getCandidateQuestionAnswerByTestIdAndQuestionId(
                    $cadidateTest->getId(), $nextQuestionId);
        } else {
            $this->view->firstQuestion = $this->candidateQuestionAnswerMapper->generateQuestionsFromCategories(
                    $this->view->categoryId, $cadidateTest->getId());
          
        }
    }

    public function getDateDiff($startTime, $endTime)
    {
        $current = $endTime;
        $last = date_create($startTime);
        $dateDiff = date_diff($current, $last);
        // var_dump($dateDiff);
        return $dateDiff->format('%I.%S');
    }

    private function getMarkSheetPdf($candidateTestId )
    {
           try{
         $cadidateTest = $this->getCandidateTestInfo();
            
          
             $candidateTestAnswersMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
            $this->view->testResult = $candidateTestAnswersMapper->getCandidateTestResult(
                    $candidateTestId);
            $this->view->candidateDetails = $this->getCandidateDetails(
                    $candidateTestId);
            $output = $this->view->render('test/get-pdf-marksheet.phtml');
            require_once ('Tcpdf/tcpdf.php');
            $pdf = new TCPDF();
            // set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ANSH ONLINE INTERVIEW APP');
$pdf->SetTitle('Result for'. $cadidateTest->getTest()->getTestName());
$pdf->SetSubject('Result of ' . $cadidateTest->getCandidate()->getUser()->getFullName() . " for " .$cadidateTest->getTest()->getTestName());

// set header and footer off
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT,0, PDF_MARGIN_RIGHT);
$pdf->SetFooterMargin(0);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 5);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('helvetica', '', 9);

// add a page
$pdf->AddPage();

// create some HTML content
$html = $this->view->render('test/get-pdf-marksheet.phtml');
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
return $pdf->Output('marksheet_'. $cadidateTest->getCandidate()->getUser()->getFullName()  .'.pdf', 'S');

        } catch (Exception $ex) {
            echo $ex->getMessage();
        } 
    }

    public function thankYouAction()
    {
        try {
            $cadidateTest = $this->getCandidateTestInfo();
            $candidateTestId = $cadidateTest->getId();
       $marklist = $this->getMarkSheetPdf($candidateTestId);
       $mailTranport = new ANSH_Resources_Helpers_Mail();
       $mailTranport->testReviewAlert($marklist,  $this->getCandidateDetails($candidateTestId));
            $this->view->message = (! empty($this->view->message)) ? $this->view->message : 'Thank you for giving the Test.';
        } catch (Exception $e) {
            $this->view->message = $e->getMessage();
        }
    }

    private function getCandidateDetails($candidateTestId)
    {
    	$candidateMapper = new Admin_Model_CandidateTestMapper();
    	return $candidate = $candidateMapper->getCatndidateTestById(
    			$candidateTestId);
    }

    public function thankAction()
    {
        // action body
    }

    private function getPdfMarksheetAction()
    {
    }


}


