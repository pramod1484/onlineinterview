<?php

/**
 * CandidateQuestionAnswerMapper for communicate with doctrine CandidateQuestionAnswer entity
 */
class Candidate_Model_CandidateQuestionAnswerMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    private $questionCategories;

    protected $questions;

    /**
     *
     * @var type CandidateTests doctrine entity
     */
    protected $_candidateQuestionAnswerDoctrineOb;

    private $errors = array();

    /**
     * constructor initialize entityManager , CandidateTestsTableEntity
     */
    public function __construct ($testId = NULL)
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_candidateQuestionAnswerDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_CandidateQuestionAnswers');
        $this->setCandidateTestCategories($testId);
    }

    public function save ($inputData)
    {
        try {
            // checks already assigned test or not
            if (! isset($inputData['id'])) {
                $candidateAnswerData = new ANSH_Shared_Model_Entity_CandidateQuestionAnswers();
                $candidateAnswerData->setCreatedDate(new DateTime());
                if (isset($inputData['questionId'])) {
                    if ($candidateAnswer = $this->getCandidateQuestionAnswerByTestIdAndQuestionId(
                            $inputData['candidateTestId'], 
                            $inputData['questionId'])) {
                        return $candidateAnswer;
                    }
                }
                $remark = 0;
                $candidateAnswerData->setQuestionBank(
                        $this->_em->getReference(
                                'ANSH_Shared_Model_Entity_QuestionBank', 
                                $inputData['questionId']));
                $candidateAnswerData->setCandidateTest(
                        $this->_em->getReference(
                                'ANSH_Shared_Model_Entity_CandidateTests', 
                                $inputData['candidateTestId']));
            } else {
                $candidateAnswerData = $this->getCandidateQuestionAnswerById(
                        $inputData['id']);
                $candidateAnswerData->setAnswers($inputData['answers']);
                $questionTypeId = $candidateAnswerData->getQuestionBank()
                    ->getQuestionType()
                    ->getId();
                if ($questionTypeId == 3 || $questionTypeId == 4) {
                    $remark = 4;
                    $candidateAnswerData->getCandidateTest()->setRemark(2);
                } else {
                    $remark = $this->calculateRemark($inputData['answers'], 
                            $candidateAnswerData->getQuestionBank()
                                ->getAnswers());
                }
                $candidateAnswerData->setMarksScored(
                        ($remark == 1) ? $candidateAnswerData->getQuestionBank()
                            ->getMarks() : 0);
                $candidateAnswerData->setTimeTaken($inputData['timeTaken']);
            }
            $candidateAnswerData->setRemark($remark);
            $this->_em->persist($candidateAnswerData);
            $this->_em->flush();
            
            return $candidateAnswerData;
        } catch (Exception $ex) {
            echo $this->errors['error'] = $ex->getMessage();
            // return FALSE;
        }
    }

    public function setTimeUp ($testId, $questionId)
    {
        try {
            $query = $this->_em->createQuery(
                    "UPDATE ANSH_Shared_Model_Entity_CandidateQuestionAnswers q SET q.remark = 5 where q.candidateTest = ?1 AND q.id >= ?2");
            $query->setParameter(1, $testId);
            $query->setParameter(2, $questionId);
            $query->execute();
            return TRUE;
        } catch (Exception $e) {
            $this->errors = $e->getMessage();
            return FALSE;
        }
    }

    private function calculateRemark ($answer, $rightanswer)
    {
        switch ($answer) {
            // case (unserialize($answer) = "") : return 3;
            case ($answer == $rightanswer):
                return 1;
            case ($answer != $rightanswer):
                return 2;
            default:
                return 5;
        }
    }

    public function updateMarks ($testId, $questionId, $mark)
    {
        try {
            $question = $this->getCandidateQuestionAnswerById($questionId);
            if ($mark > $question->getQuestionBank()->getMarks()) {
                $this->errors = 'You can\'t give marks more than assigned to question! ';
                return false;
            }
            if ($mark < 0) {
                $this->errors = 'You can\'t give marks less than 0! ';
                return false;
            }
            if (fmod($mark, 0.5) != 0) {
                $this->errors = 'Marks should be in-form 0.5 , 1 ,1.5 and so on';
                return false;
            }
            //TODO removecomment if once edited marks not alow to modify
//             if ($question->getRemark() != 5 &&
//                      ($question->getMarksScored() != '')) {
//                 $this->errors = 'This question marks already updated! ';
//                 return false;
//             }
            $question->setMarksScored(round($mark * 2) / 2);
            $question->setRemark(($mark == 0) ? 2 : 1);
            $this->_em->persist($question);
            $this->_em->flush();
            try {
                $totalTestMarks = $this->getTotalByCandidateTestId($testId);
                $candidateTestMapper = new Admin_Model_CandidateTestMapper();
                $candidateTestMapper->updateRemark($testId);
                $candidateTestMapper->setTestTotalMarks($testId, 
                        $totalTestMarks);
            } catch (Exception $ex) {
                $this->errors = $e->getMessage();
                return false;
            }
            return $this->getResultByCategory(
                    $question->getQuestionBank()
                        ->getcategory()
                        ->getId(), $testId);
        } catch (Exception $e) {
            $this->errors = $e->getMessage();
            return false;
        }
    }

    public function getCandidateQuestionAnswerById ($questionId)
    {
        return $this->_candidateQuestionAnswerDoctrineOb->find($questionId);
    }

    public function generateQuestionsFromCategories ($catId, $testId)
    {
        try {
            foreach ($this->questionGenerator($catId) as $question) {
                $inputData['questionId'] = $question->getId();
                $inputData['candidateTestId'] = $testId;
                $candidateQuestionAnswer = $this->save($inputData);
                $this->questions[] = array(
                        'id' => $question->getId()
                );
            }
            $questionId['last'] = $this->questions[count(($this->questions)) - 1]['id'];
            $questionId['first'] = $this->questions[0]['id'];
            return $questionId;
        } catch (Exception $e) {
            $this->errors['error'] = $e->getMessage();
            return FALSE;
        }
    }

    private function questionGenerator ($catId)
    {
        $questionsMapper = new Admin_Model_QuestionMapper();
        return $questions = $questionsMapper->getQuestionsByCategoryId($catId);
        // TODO uncomment when php version < 5.5
        // for($i = 0 ; $i < count($questions); $i++){
        // yield $questions[$i];
        // }
    }

    public function getQuestionCountByTestId ($testId, $status = 0)
    {
        try {
            $query = $this->_em->createQuery(
                    "Select Count(q.id) FROM  ANSH_Shared_Model_Entity_CandidateQuestionAnswers q  WHERE q.remark = ?2 AND q.candidateTest = ?1");
            $query->setParameter(1, $testId);
            $query->setParameter(2, $status);
            return $query->getSingleScalarResult();
        } catch (Exception $ex) {
            echo $this->errors['error'] = $ex->getMessage();
            // return FALSE;
        }
    }

    public function getQuestionsByTestId ($testId, $offset = NULL)
    {
        try {
            $query = $this->_em->createQuery(
                    "SELECT q FROM  ANSH_Shared_Model_Entity_CandidateQuestionAnswers q  WHERE q.candidateTest = ?1 AND q.questionBank = ?2");
            $query->setParameter(1, $testId);
            $query->setParameter(2, $this->questions[0]['id']);
            $query->setMaxResults(1);
            return $query->getResult();
        } catch (Exception $e) {
            $this->errors['error'] = $ex->getMessage();
            return FALSE;
        }
    }

    public function getQuestionsByTestAndCategory ($testId, $categoryId)
    {
        try {
            $query = $this->_em->createQuery(
                    'SELECT q,(qb.question),(qb.marks) scored,(qb.answers) FROM ANSH_Shared_Model_Entity_CandidateQuestionAnswers q JOIN q.questionBank qb  where qb.category = ?1 AND q.candidateTest = ?2');
            $query->setParameter(1, $categoryId);
            $query->setParameter(2, $testId);
            return $query->getScalarResult();
        } catch (Exception $e) {
            $this->errors['error'] = $e->getMessage();
            return FALSE;
        }
    }

    public function getTotalByCandidateTestId ($testId)
    {
        try {
            $query = $this->_em->createQuery(
                    "SELECT SUM(q.marksScored) FROM  ANSH_Shared_Model_Entity_CandidateQuestionAnswers q  WHERE q.candidateTest = ?1");
            $query->setParameter(1, $testId);
            return $query->getSingleScalarResult();
        } catch (Exception $e) {
            $this->errors['error'] = $e->getMessage();
            return FALSE;
        }
    }
    
    // public function getCandidateTestResult($candidateTestId)
    // {
    // $query = $this->_em->createQuery('SELECT q,qb FROM
    // ANSH_Shared_Model_Entity_CandidateQuestionAnswers q JOIN q.questionBank
    // qb where q.candidateTest = ?1 ORDER BY qb.category,q.id ');
    // $query->setParameter(1,$candidateTestId);
    // return($query->getResult());
    // // return
    // $this->_candidateQuestionAnswerDoctrineOb->findBy(array('candidateTest'
    // => $candidateTestId));
    // }
    public function getCandidateTestResult ($candidateTestId)
    {
        $testCategories = $this->getCategoryDetailsByCandidateTestId(
                $candidateTestId);
        $testCats = array();
        foreach ($testCategories as $category) {
            $category['result'] = $this->getResultByCategory($category['id'], 
                    $candidateTestId);
            $category['questionDetails'] = $this->getQuestionsByTestAndCategory(
                    $candidateTestId, $category['id']);
            
            $testCats[] = ($category);
        }
        return $testCats;
    }

    public function getTestTotalByTestId ($candidateTestId)
    {
        $query = $this->_em->createQuery(
                'SELECT SUM(qb.marks) totalMarks FROM ANSH_Shared_Model_Entity_CandidateQuestionAnswers q JOIN q.questionBank qb  where q.candidateTest = ?1');
        $query->setParameter(1, $candidateTestId);
        return $total = $query->getSingleScalarResult();
    }

    public function getResultByCategory ($categoryId, $CandidateTestId)
    {
        $query = $this->_em->createQuery(
                'SELECT SUM(q.timeTaken) timeTaken,SUM(q.marksScored) scored ,SUM(qb.marks) catTotal FROM ANSH_Shared_Model_Entity_CandidateQuestionAnswers q JOIN q.questionBank qb  where qb.category = ?1 AND q.candidateTest = ?2 AND qb.deleted = 0');
        $query->setParameter(1, $categoryId);
        $query->setParameter(2, $CandidateTestId);
        return ($query->getSingleResult());
    }

    public function getCategoryDetailsByCandidateTestId ($candidateTestId)
    {
        $query = $this->_em->createQuery(
                'SELECT DISTINCT(c.id),(c.categoryName),(c.totalMarks) total, (c.timeToFinish)  FROM ANSH_Shared_Model_Entity_CandidateQuestionAnswers q JOIN q.questionBank qb JOIN qb.category c where q.candidateTest = ?1 AND qb.deleted = 0 ORDER BY qb.category');
        $query->setParameter(1, $candidateTestId);
        return ($query->getArrayResult());
    }
    
    public function getTestCategoriesByPosition($position = NULL)
    {
        try{
            $queryBuilder = $this->_em->createQueryBuilder();
            $queryBuilder->select(array('cat.id','cat.categoryName'))
                        ->from('ANSH_Shared_Model_Entity_CandidateQuestionAnswers','qa')
                        ->leftJoin('qa.questionBank','qb','WITH')
                        ->leftJoin('qb.category','cat','WITH')
                        ->join('qa.candidateTest','ctest','WITH');
                    if($position != NULL) {
                      $queryBuilder->join('ctest.candidate','c','WITH','c.jobPosition = :position');
                       
            $queryBuilder->setParameter('position',$position);
                    }
             $queryBuilder->groupBy('cat.id');
            $q=($queryBuilder->getQuery()->getScalarResult());
            $cat = array();
            foreach ($q as $s){
                $cat[$s['id']] = $s['categoryName'];
            }
            return $cat;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

    private function setCandidateTestCategories ($testId)
    {
        $testCategories = new Admin_Model_TestCategoryMapper();
        $this->questionCategories = $testCategories->getTestCetegoriesforTest(
                $testId);
    }

    public function getCandidateTestCategories ()
    {
        return $this->questionCategories;
    }

    public function removeCategoryKey ($key)
    {
        unset($this->questionCategories[$key]);
    }
    
    // get question is answers or not
    public function getCatndidateTestByQuestionId ($questionId)
    {
        try {
            $test = $this->_candidateQuestionAnswerDoctrineOb->findOneBy(
                    array(
                            'questionBank' => $questionId
                    ));
            return $test;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getCandidateQuestionAnswerByTestIdAndQuestionId ($testId, 
            $questionId)
    {
        try {
            $test = $this->_candidateQuestionAnswerDoctrineOb->findOneBy(
                    array(
                            'candidateTest' => $testId,
                            'questionBank' => $questionId
                    ));
            if ($test)
                $test->nextRow = $this->getNextRow(
                        $test->getQuestionBank()
                            ->getCategory()
                            ->getId(), $test->getQuestionBank()
                            ->getId());
            return $test;
        } catch (Exception $e) {
            $this->errors['error'] = $e->getMessage();
            return FALSE;
        }
    }

    public function getNextRow ($categoryId, $questionId)
    {
        try {
            $query = $this->_em->createQuery(
                    "SELECT q.id FROM  ANSH_Shared_Model_Entity_QuestionBank q  WHERE q.category = ?1 AND q.id > ?2 ");
            $query->setParameter(1, $categoryId);
            $query->setParameter(2, $questionId);
            $query->setMaxResults(1);
            return $query->getSingleScalarResult();
        } catch (Exception $e) {
            $this->errors['error'] = $e->getMessage();
            return FALSE;
        }
    }

    public function getQuestions ()
    {
        return $this->questions;
    }

    public function getErrors ()
    {
        return $this->errors;
    }
}
