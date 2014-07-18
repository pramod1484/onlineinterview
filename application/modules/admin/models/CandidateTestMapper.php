<?php

/**
 * Candidate test Mapper for communicate with doctrine candidate test entity
 */
class Admin_Model_CandidateTestMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type CandidateTests doctrine entity
     */
    protected $_candidateTestDoctrineOb;

    
    protected $errors ='Something is wrong!';
    
    /**
     * constructor initialize entityManager , CandidateTestsTableEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_candidateTestDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_CandidateTests');
    }
    
    // save test alongwith candidate
    public function save ($candidateId, $testId)
    {
        try {
            $candidateTest = $this->getCatndidateTestByCandidateId($candidateId);
            
            
            // checks already assigned test or not
            if (is_null($candidateTest)) {
                $candidateTest = new ANSH_Shared_Model_Entity_CandidateTests();
                $candidateTest->setCreatedDate(new DateTime());
            }else{
                // throw exception if test changed
                if($candidateTest->getTest()->getId() != $testId && $candidateTest->getRemark() != 0) {
                	throw new Exception('Test already given by this candidate.');
                }
            }
            
            $candidateTest->setCandidate(
                    $this->_em->getReference(
                            'ANSH_Shared_Model_Entity_Candidates', $candidateId));
            $candidateTest->setTest(
                    $this->_em->getReference('ANSH_Shared_Model_Entity_Tests', 
                            $testId));
            $this->_em->persist($candidateTest);
            $this->_em->flush();
            
            return $candidateTest;
        } catch (Exception $ex) {
            $this->errors = $ex->getMessage();
            return FALSE;
        }
    }
    
    // get assigned test to candidate
    public function getCatndidateTestByCandidateId ($candidateId)
    {
        try {
            $test = $this->_candidateTestDoctrineOb->findOneBy(
                    array(
                            'candidate' => $candidateId
                    ));
            return ($test);
        } catch (Exception $e) {
            $this->errors =  $e->getMessage();
            return FALSE;
        }
    }

    public function setTestStartTime ($candidateTestId, $dateTime)
    {
        try {
            $candidateTestId;
            $candidateTestData = $this->getCatndidateTestById($candidateTestId);
            $candidateTestData->setStartTime(
                    (! is_null($candidateTestData->getStartTime())) ? $candidateTestData->getStartTime() : new DateTime());
            $this->_em->persist($candidateTestData);
            $this->_em->flush();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function setTestEndTimeandStatus ($candidateTestId)
    {
        try {
            $candidateTestData = $this->getCatndidateTestById($candidateTestId);
            $candidateTestData->setEndTime(
                    (! is_null($candidateTestData->getEndTime())) ? $candidateTestData->getEndTime() : new DateTime());
            $this->updateRemark($candidateTestId);
            $this->setTestTotalMarks($candidateTestId);
            $this->_em->persist($candidateTestData);
            $this->_em->flush();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function updateRemark ($candidateTestId)
    {
        try {
            $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
            $questionToBeReviewed = $candidateQuestionAnswerMapper->getQuestionCountByTestId(
                    $candidateTestId, 4);
            $candidateTestData = $this->getCatndidateTestById($candidateTestId);
            $candidateTestData->setRemark(($questionToBeReviewed > 0) ? 2 : 1);
            $this->_em->persist($candidateTestData);
            $this->_em->flush();
            return $candidateTestData;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function setTestTotalMarks ($candidateTestId, $totalMarks = NULL)
    {
        try {
            if ($totalMarks == NULL) {
                $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
                $totalMarks = $candidateQuestionAnswerMapper->getTotalByCandidateTestId(
                        $candidateTestId);
            }
            $candidateTestData = $this->getCatndidateTestById($candidateTestId);
            $candidateTestData->setTotalMarks($totalMarks);
            $this->_em->persist($candidateTestData);
            $this->_em->flush();
            return $candidateTestData;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    // get assigned test to candidate
    public function getCatndidateTestById ($candidateTestId)
    {
        try {
            $test = $this->_candidateTestDoctrineOb->find($candidateTestId);
            return $test;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    // get assigned test to candidate
    public function getCatndidateTestByTestId ($testId, $remark = 0)
    {
        try {
            echo $testId;
            $queryBuilder = $this->_em->createQueryBuilder();
            $queryBuilder->select(array(
                    'c'
            ))
                ->from('ANSH_Shared_Model_Entity_CandidateTests', 'c')
                ->where('c.test = ' . $testId);
            if ($remark != 0)
                $queryBuilder->where('c.remark = ' . $remark);
            else {
                $queryBuilder->where('c.remark != ' . $remark);
            }
            
            $queryBuilder->setMaxResults(1);
            
            return ($candidatesAllData = $queryBuilder->getQuery()->getScalarResult());
           
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function getAllTestByTechnologyId($technologyId)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select(array(
        		'c'
        ))->from('ANSH_Shared_Model_Entity_CandidateTests', 'c')
        ->JOIN('c.test','t','WITH','t.technology = ?1')
        ->andWhere('c.remark != 0');
        $queryBuilder->setParameter(1,$technologyId);
        return $candidatesTestData = $queryBuilder->getQuery()->getResult();
        
    }   
     
    public function getAllTestsByCandidate ($page = NULL, $remark = 0 ,$position = NULL , $fromDate= NULL,$toDate =NULL)
    {
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select(array(
                't'
        ))->from('ANSH_Shared_Model_Entity_CandidateTests', 't');
        if($position != NULL){
            $queryBuilder->JOIN('t.candidate','c','WITH','c.jobPosition = :positionId');
            $queryBuilder->setParameter('positionId',$position);
        }
       
        if ($remark != 0)
            $queryBuilder->where('t.remark = ' . $remark);
        else {
            $queryBuilder->where('t.remark != ' . $remark);
        }

        if ($fromDate != NULL && $toDate != NULL) {
                $queryBuilder->andWhere(
                        $queryBuilder->expr()
                            ->orx(
                                $queryBuilder->expr()
                                    ->between('t.startTime', '?1','?2'))

                        );
                   $queryBuilder->setParameter(1, $fromDate ." 00:00:00");
                $queryBuilder->setParameter(2, $toDate." 23:59:59");
        }
       
        $queryBuilder->orderBy('t.createdDate', 'DESC');
        return $candidatesAllData = $queryBuilder->getQuery()->getResult();
     }

     function getTestCategoriesByPosition($position)
     {
         try{
            $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
        return $candidateQuestionAnswerMapper->getTestCategoriesByPosition($position);
         } catch (Exception $ex) {
            echo  $this->errors = $ex->getMessage();exit;
             return FALSE;
         }
     }
    public function getAllCandidateTestResults ($page = NULL, $remark = 0)
    {
        try {
           
            $candidateData = $this->getAllTestsByCandidate($page, $remark);
            foreach ($candidateData as $candidateTest) {
                $candidateTest->total = $this->getTestTotalByCandidateTestId($candidateTest->getId());
            }
            return $candidateData;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function getAllCategoryWiseCandidateTestResults ($page = NULL, $remark = 0)
    {
        try {
            
            $candidateData = $this->getAllTestsByCandidate($page, $remark);
            foreach ($candidateData as $candidateTest) {
                $candidateTest->total = $this->getTestTotalByCandidateTestId($candidateTest->getId());
                $candidateTest->testResult = $this->getCategoryWiseTestResultBycandidateTestId($candidateTest->getId());
            }
            return $candidateData;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function getAllPositionWiseCandidateTestResults ($page = NULL, $remark = 0 , $position = NULL , $fromDate =NULL , $toDate = NULL)
    {
        try {
             
             $candidateData = $this->getAllTestsByCandidate($page, $remark ,$position ,$fromDate , $toDate);
            foreach ($candidateData as $candidateTest) {
                $candidateTest->total = $this->getTestTotalByCandidateTestId($candidateTest->getId());
                $candidateTest->testResult = $this->getCategoryWiseTestResultBycandidateTestId($candidateTest->getId());
            }
            return $candidateData;
        } catch (Exception $e) {
         echo   $this->errors = $e->getMessage();exit;
            return FALSE;
        }
    }
    private function getTestTotalByCandidateTestId($candidateTestId)
    {
        $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
        return $candidateQuestionAnswerMapper->getTestTotalByTestId($candidateTestId);
    }
    private function getCategoryWiseTestResultBycandidateTestId($candidateTestId)
    {
         $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
        return $candidateQuestionAnswerMapper->getCandidateTestResult($candidateTestId);
    }
    /**
     *
     * @return type array
     *         function to return errors
     */
    public function getErrors ()
    {
    	return $this->errors;
    }
}
