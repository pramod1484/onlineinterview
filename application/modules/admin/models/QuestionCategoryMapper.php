<?php

/**
 * Question category Mapper for communicate with doctrine QuestionCategory entity
 */
class Admin_Model_QuestionCategoryMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type QuestionCategory doctrine entity
     */
    protected $_categoryDoctrineOb;
    // error array to set errors
    private $errors = array();

    /**
     * constructor initialize entityManager , userTableEntity and repository
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_categoryDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_QuestionCategories');
    }
    
    // save question category
    public function save ($categoryData)
    {
        try {
            
            // check category exist if yes edit or create new question category
            if (! isset($categoryData['id'])) {
                $newCategory = new ANSH_Shared_Model_Entity_QuestionCategories();
                $newCategory->setCreatedDate(new \DateTime());
            } else
                $newCategory = $this->getCategoryById($categoryData['id']);
            
            $newCategory->setCategoryName($categoryData['categoryName']);
            $newCategory->setCategoryImage($categoryData['categoryImage']);
            $newCategory->setTimeToFinish($categoryData['timeToFinish']);
            $newCategory->setIsEnabled(true);
            
            $this->_em->persist($newCategory);
            $this->_em->flush();
            return $newCategory->getCategoryName();
        } catch (Exception $e) {
            $this->errors['error'] = "Somethinges goes wrong! \n maybe same name already exist";
            return FALSE;
        }
        // TODO uncomment when php version 5.5 <
        // finally {
        // }
    }
    
    // question category by it's id
    public function getCategoryById ($categoryId)
    {
        return $this->_categoryDoctrineOb->find($categoryId);
    }
    
    // delete question category image
    public function deleteCategoryImage ($categoryId)
    {
        $category = $this->getCategoryById($categoryId);
        if (unlink(
                CATEGORY_IMAGE . DIRECTORY_SEPARATOR .
                         $category->getCategoryImage())) {
            try {
                $category->setCategoryImage('');
                $this->_em->persist($category);
                $this->_em->flush();
                return 1;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }
    
    // delete existing category
    public function deleteCategory ($categoryId)
    {
        try {
            $category = $this->getCategoryById($categoryId);
            if (null !== $category) {
                if (! is_null($category->getCategoryImage()) ||
                         $category->getCategoryImage() != '')
                    $this->deleteCategoryImage($categoryId);
                
                $this->_em->remove($category);
                $this->_em->flush();
                return $category;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    // get all question categories
    public function getAllCategories ($page = NULL, $enabled = false)
    {
        return ($enabled) ? $this->_categoryDoctrineOb->findBy(
                array(
                        'isEnabled' => $enabled
                )) : $this->_categoryDoctrineOb->findAll();
    }

    public function getPaginationData ($page = NULL, $enabled = false)
    {
        // zend pagination factory object
        $paginatorData = Zend_Paginator::factory(
                $this->getAllCategories($page, $enabled));
        $paginatorData->setItemCountPerPage(5);
        $paginatorData->setCurrentPageNumber($page);
        return $paginatorData;
    }

    public function getCategorySumByTestId ($testId)
    {
        try {
            $query = $this->_em->createQuery(
                    "SELECT SUM(q.totalMarks) FROM ANSH_Shared_Model_Entity_QuestionCategories q WHERE q.id in(SELECT (t.category) FROM ANSH_Shared_Model_Entity_TestCategories t where t.test = :testId)");
            $query->setParaMeter('testId', $testId);
            return $query->getSingleScalarResult();
        } catch (Exception $e) {
            $this->errors['error'] = $e->getMessage();
            return FALSE;
        }
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
