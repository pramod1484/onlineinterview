<?php

/**
 * TestMapper for communicate with doctrine Test entity
 */
class Admin_Model_TestMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type Test doctrine entity
     */
    protected $_testDoctrineOb;

    /**
     *
     * @var type testCategory Mapper
     */
    protected $_testcategoryMapper;

    private $errors = 'something is going wrong';

    /**
     * constructor initialize entityManager , Test Entity and testCategoryMapper
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_testDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_Tests');
        $this->_testcategoryMapper = new Admin_Model_TestCategoryMapper();
    }
    
    // save test
    public function save ($testData)
    {
        try {
            $this->_em->beginTransaction();
            
            // check existing test if yes then edit
            if (! isset($testData['id'])) {
                $newTest = new ANSH_Shared_Model_Entity_Tests();
                $newTest->setCreatedDate(new DateTime());
            } else
                $newTest = $this->getTestById($testData['id']);
            
            $newTest->setTestName($testData['testName']);
            $newTest->setTechnology(
                    $this->_em->getReference(
                            'ANSH_Shared_Model_Entity_Technology', 
                            $testData['technology']));
            $this->_em->persist($newTest);
            $this->_em->flush();
            
            // check is categories assigned
            if (count($testData['category'])) {
                
                // check if test id set and categories then delete the test
                // category pairs
                if (isset($testData['id'])) {
                    $this->_testcategoryMapper->deleteTestCategories(
                            $newTest->getId());
                }
            }
            $questionMapper = new Admin_Model_QuestionMapper();
            $categoryMapper = new Admin_Model_QuestionCategoryMapper();
            foreach ($testData['category'] as $key => $value) {
                try {
                    $questionCount = count(
                            $questionMapper->getQuestionsByCategoryId($value));
                    if ($questionCount <= 0) {
                        $category = $categoryMapper->getCategoryById($value);
                        throw new Exception(
                                'No any question added for ' .
                                         $category->getCategoryName() .
                                         ' category . No test will be added without questions to related category. ');
                    }
                    $this->_testcategoryMapper->save(
                            $this->_em->getReference(
                                    'ANSH_Shared_Model_Entity_Tests', 
                                    $newTest->getId()), 
                            $this->_em->getReference(
                                    'ANSH_Shared_Model_Entity_QuestionCategories', 
                                    $value));
                } catch (Doctrine\ORM\Tools\Export\ExportException $exp) {
                    
                    $this->_em->rollback();
                    $this->errors = $exp->getMessage();
                    return FALSE;
                }
            }
            $this->_em->commit();
            return $newTest;
        } catch (Doctrine\ORM\Tools\Export\ExportException $e) {
            
            $this->errors = $e->getMessage();
        } catch (Exception $e) {
            
            $this->errors = $e->getMessage();
            return FALSE;
        }
    }
    
    // get test by id
    public function getTestById ($testId)
    {
        $testData = $this->_testDoctrineOb->find($testId);
        if ($testData) {
            $testData->categories = array_keys(
                    $this->_testcategoryMapper->getTestCetegories($testId));
            $testData->count = $this->getQuestionAnswerByTestId($testId);
        }
        return $testData;
    }

    public function getTestCountByTechnologyId ($technologyId)
    {
        try {
            $testData = $this->_testDoctrineOb->findBy(
                    array(
                            'technology' => $technologyId
                    ));
            foreach ($testData as $key => $test) {
                $test->categories = implode('<span class="tag">,', 
                        $this->_testcategoryMapper->getTestCetegories(
                                $test->getId()));
            }
            return count($testData);
        } catch (Exception $e) {
            $this->errors = $e->getMessage();
        }
    }
    
    // get All tests
    public function getAllTests ($page = NULL)
    {
        try {
            $testData = $this->_testDoctrineOb->findAll();
            foreach ($testData as $key => $test) {
                $test->categories = implode('<span class="tag">,', 
                        $this->_testcategoryMapper->getTestCetegories(
                                $test->getId()));
            }
            return $testData;
            // //zend pagination factory object
            // $paginatorData = Zend_Paginator::factory($testData);
            // $paginatorData->setItemCountPerPage(5);
            // $paginatorData->setCurrentPageNumber($page);
            // $args = array_shift(func_get_arg(1));
            // return ($args === TRUE ) ? $paginatorData : $testData;
        } catch (Doctrine\ORM\EntityNotFoundException $e) {
            $test->errors = $e->getMessage();
        } catch (Exception $e) {
            $test->errors = $e->getMessage();
            return FALSE;
        }
    }

    private function getQuestionAnswerByTestId ($testId)
    {
        $candidateQuestionAnswerMapper = new Candidate_Model_CandidateQuestionAnswerMapper();
        return $candidateQuestionAnswerMapper->getQuestionCountByTestId($testId);
    }

    private function getTestStatus ($testId)
    {
        $candidateTestMapper = new Admin_Model_CandidateTestMapper();
        return $candidateTestMapper->getCatndidateTestByTestId($testId);
    }

    public function deleteTest ($testId)
    {
        try {
            
            $result = $this->getTestStatus($testId);
            if (! empty($result)) {
                $this->errors = array(
                        'error' => 'You cant not delete this test as test has been started or completed.'
                );
                return FALSE;
            }
            $test = $this->getTestById($testId);
            $this->_em->remove($test);
            $this->_em->flush();
            return $test->getTestName();
        } catch (Exception $e) {
            $this->errors = array(
                    'error' => $e->getMessage()
            );
            return FALSE;
        }
    }

    public function getErrors ()
    {
        return $this->errors;
    }
}
