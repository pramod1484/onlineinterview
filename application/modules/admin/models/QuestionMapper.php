<?php

/**
 * 
 * QuestionMapper for communicate with doctrine QuestionBank entity
 */
class Admin_Model_QuestionMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type QuestionBank doctrine entity
     */
    protected $_questionDoctrineOb;

    private $errors = array();

    /**
     * constructor initialize entityManager , questionBankTableEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_questionDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_QuestionBank');
    }
    
    // save question
    public function save ($questionData)
    {
        try {
            
            // check if already question exists then edit
            if (! isset($questionData['id'])) {
                $newCategory = new ANSH_Shared_Model_Entity_QuestionBank();
                $newCategory->setCreatedDate(new \DateTime());
            } else {
                $newCategory = $this->getQuestionById($questionData['id']);
                $candidateQuestionAnswersMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
                $questionId = $candidateQuestionAnswersMapper->getCatndidateTestByQuestionId(
                        $questionData['id']);
                if ($questionId) {
                    $this->errors = 'Question attempted by candidate can not be modify.';
                    return FALSE;
                }
            }
            
            $newCategory->setQuestion(stripcslashes($questionData['question']));
            $newCategory->setMarks($questionData['marks']);
            $newCategory->setOptions($this->getOptionsFromPost($questionData));
            $newCategory->setAnswers($this->getAnswersFromPost($questionData));
            $newCategory->setDeleted(FALSE);
            $newCategory->setCategory(
                    $this->_em->getReference(
                            'ANSH_Shared_Model_Entity_QuestionCategories', 
                            $questionData['categoryId']));
            $newCategory->setQuestionType(
                    $this->_em->getReference(
                            'ANSH_Shared_Model_Entity_QuestionTypes', 
                            $questionData['questionType']));
            $this->_em->persist($newCategory);
            $this->_em->flush();
            $newCategory->getCategory()->setTotalMarks(
                    $this->getTotalMarksByCategoryId(
                            $newCategory->getCategory()
                                ->getId()));
            $this->_em->persist($newCategory);
            
            $this->_em->flush();
            
            return 1;
        } catch (Doctrine\ORM\Tools\Export\ExportException $exc) {
            $this->errors = $exc->getMessage();
            return FALSE;
        }
    }

    public function getErrors ()
    {
        return $this->errors;
    }
    
    // get total marks to ralated category
    private function getTotalMarksByCategoryId ($categoryId)
    {
        $questions = $this->getQuestionsByCategoryId($categoryId , FALSE);
        $sum = 0;
        foreach ($questions as $question) {
            $sum += $question->getMarks();
        }
        return $sum;
    }
    
    // get and return answer as selected options
    private function getAnswersFromPost ($questionData)
    {
        switch ($questionData['questionType']) {
            case '1':
                return serialize($questionData['checkBoxAnswer']);
            case '2':
                return serialize($questionData['radioAnswer']);
            case '3':
                return serialize($questionData['freeTextArea']);
            case '4':
                return serialize($questionData['freeTextbox']);
            default:
                return '';
        }
    }
    
    // get options from post
    private function getOptionsFromPost ($questionData)
    {
        switch ($questionData['questionType']) {
            case '1':
            case '2':
                return serialize($questionData['options']);
            
            default:
                return '';
        }
    }
    
    // delete pericular question
    public function deleteQuestionById ($questionId)
    {
        try {
            
            if (null !== ($question = $this->getQuestionById($questionId))) {
                $totalMarks = ($question->getCategory()->getTotalMarks() -
                         $question->getMarks()) ?  : 0;
                $question->getCategory()->setTotalMarks($totalMarks);
               $question->setDeleted(TRUE);
                 $this->_em->persist($question);
            
            $this->_em->flush();
            }
            return 1;
        } catch (Exception $exc) {
            echo $exc->getMessage();
            return 0;
            exit();
        }
        
        $question = $this->getQuestionById($questionId);
        $this->_em->remove($question);
        $this->_em->flush();
        return 1;
    }
    
    // get question by id
    public function getQuestionById ($questionId , $deleted = FALSE)
    {
        return $this->_questionDoctrineOb->findOneBy(array('id' => $questionId , 'deleted' => $deleted));
    }

    public function getQuestionsByCategoryId ($categoryId , $deleted = FALSE)
    {
        return $this->_questionDoctrineOb->findBy(
                array(
                        'category' => $categoryId ,
                        'deleted' => $deleted
                ));
    }
    
    // get all question
    public function getAllQuestions ($page = NULL , $deleted = FALSE)
    {
        return $questionData = $this->_questionDoctrineOb->findBy(array('deleted' => $deleted));
        // TODO uncomment while zend pagination
        // zend pagination factory object
        // $paginatorData = Zend_Paginator::factory($questionData);
        // $paginatorData->setItemCountPerPage(2);
        // $paginatorData->setCurrentPageNumber($page);
        // return $paginatorData;
    }
}
