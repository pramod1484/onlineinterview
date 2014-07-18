<?php

/**
 * TestCategoryMapper for communicate with doctrine TestCategory entity
 */
class Admin_Model_TestCategoryMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type TestCategory doctrine entity
     */
    protected $_testCategoryDoctrineOb;

    /**
     * constructor initialize entityManager , TestCategoryEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_testCategoryDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_TestCategories');
    }
    
    // save test category
    public function save ($testId, $categoryId)
    {
        try {
            $newTestCategory = new ANSH_Shared_Model_Entity_TestCategories();
            $newTestCategory->setCreatedDate(new DateTime());
            $newTestCategory->setTest($testId);
            $newTestCategory->setCategory($categoryId);
            $this->_em->persist($newTestCategory);
            $this->_em->flush();
            return 1;
        } catch (Doctrine\ORM\Tools\Export\ExportException $e) {
            echo $e->getMessage();
        }
    }
    
    // get all categories related to test
    public function getTestCetegories ($testId)
    {
        $categories = $this->_testCategoryDoctrineOb->findBy(
                array(
                        'test' => $testId
                ));
        $testCategories = array();
        foreach ($categories as $category) {
            $testCategories[$category->getCategory()->getId()] = $category->getCategory()->getCategoryName();
        }
        return $testCategories;
    }
    
    // get all categories related to test
    public function getTestCetegoriesforTest ($testId)
    {
        $categories = $this->_testCategoryDoctrineOb->findBy(
                array(
                        'test' => $testId
                ));
        $questionMapper = new Admin_Model_QuestionMapper();
        $testCategories = array();
        foreach ($categories as $category) {
            $testCategories[] = array(
                    'id' => $category->getCategory()->getId(),
                    'categoryName' => $category->getCategory()->getCategoryName(),
                    'timeToFinish' => $category->getCategory()->getTimeToFinish(),
                    'questionCount' => count(
                            $questionMapper->getQuestionsByCategoryId(
                                    $category->getCategory()
                                        ->getId()))
            );
        }
        return $testCategories;
    }
    
    // delete test categories
    public function deleteTestCategories ($testId)
    {
        // TODO: remove this
        // $testCategories = $this->_testCategoryDoctrineOb->findBy(array('test'
        // => $testId));
        // $this->_em->remove($testCategories);
        // $this->_em->flush();
        // return $testCategories;
        $query = $this->_em->createQuery(
                'Delete ANSH_Shared_Model_Entity_TestCategories test where test.test = ' .
                         $testId);
        return $query->getResult();
    }
}
