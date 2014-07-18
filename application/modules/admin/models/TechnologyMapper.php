<?php

/**
 * TechnologyMapper for communicate with doctrine Technology entity 
 */
class Admin_Model_TechnologyMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type Technology doctrine entity
     */
    protected $_technologyObject;
    // error array to set errors
    private $errors = 'Something goes wrong';

    /**
     * constructor initialize entityManager , technologyTableEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_technologyObject = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_Technology');
    }
    
    // save technology
    public function save ($technologyData)
    {
        try {
            
            // check editing technology or adding new
            if (! isset($technologyData['id'])) {
                $technology = new ANSH_Shared_Model_Entity_Technology();
                $technology->setCreatedDate(new \DateTime());
            } else {
                $technology = $this->getTechnologyById($technologyData['id']);
                $candidateTestMapper = new Admin_Model_CandidateTestMapper();
                $technologyWiseTest = $candidateTestMapper->getAllTestByTechnologyId($technologyData['id']);
                if($technologyWiseTest) {
                    throw new Exception('You can not change technology as test started or finished!');
                }
               
            }
            $technology->setTechnologyName($technologyData['technologyName']);
            $technology->setIsEnabled(TRUE);
            $this->_em->persist($technology);
            $this->_em->flush();
            return $technology->getId();
        } catch (Exception $e) {
            $this->errors = $e->getMessage();
            return FALSE;
        }
    }
    
    // get technology by id
    public function getTechnologyById ($technologyId)
    {
        return $this->_technologyObject->find($technologyId);
    }
    
    // get all technologies
    public function getAllTechnologyData ($page = NULL)
    {
        return $technologyData = $this->_technologyObject->findAll();
        
        // //zend pagination factory object
        // $paginatorData = Zend_Paginator::factory($technologyData);
        // $paginatorData->setItemCountPerPage(5);
        // $paginatorData->setCurrentPageNumber($page);
        // return $paginatorData;
    }

    public function deleteTechnology ($technologyId)
    {
        try {
            $testMapper = new Admin_Model_TestMapper();
            $result = $testMapper->getTestCountByTechnologyId($technologyId);
            if (! empty($result)) {
                $this->errors =  'You can not delete this technology test assign for this!';
                return FALSE;
            }
            $technology = $this->getTechnologyById($technologyId);
            $this->_em->remove($technology);
            $this->_em->flush();
            return $technology->getTechnologyName();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getErrors ()
    {
        return $this->errors;
    }
}
