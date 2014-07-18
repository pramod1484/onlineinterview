<?php

class Admin_IndexController extends Zend_Controller_Action
{

    /**
     * index action for admin dashboard
     */
    public function indexAction ()
    {
        // Get total candidate count and candidate last week added count
        $candidateMapper = new Admin_Model_CandidateMapper();
        $this->view->totalCandidate = $candidateMapper->getCandidateCount();
        $this->view->lastweekCandidate = $candidateMapper->getCandidateCount(
                TRUE);
        
        // get total candidate test given and waiting for review count
        $candidateTestMapper = new Admin_Model_CandidateTestMapper();
        $this->view->totalCandidateTestGiven = count(
                $candidateTestMapper->getAllCandidateTestResults());
        $this->view->candidateToBeReview = count(
                $candidateTestMapper->getAllCandidateTestResults(NULL, 2));
        
        // get Total test count
        $testMapper = new Admin_Model_TestMapper();
        $this->view->totalTests = count($testMapper->getAllTests());
        
        //get total categories count
        $categoriesMapper = new Admin_Model_QuestionCategoryMapper();
        $this->view->totalCategories = count(
                $categoriesMapper->getAllCategories());
        
        // get total question count
        $questionMapper = new Admin_Model_QuestionMapper();
        $this->view->totalQuestions = count($questionMapper->getAllQuestions());
        
        // get total technology count 
        $technologyMapper = new Admin_Model_TechnologyMapper();
        $this->view->totalTechnologies = count(
                $technologyMapper->getAllTechnologyData());
    }
}
