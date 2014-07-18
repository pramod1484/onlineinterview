<?php

/**
 * jobpositionMapper for communicate with doctrine JobPositions Entity
 */
class Admin_Model_JobPositions
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type JobPositions doctrine entity
     */
    protected $_jobPositionObject;

    protected $errors = '';
    /**
     * constructor initialize entityManager , JobPositionsTableEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_jobPositionObject = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_JobPositions');
    }
    
    // save job position for test
    public function save ($jobPositionData)
    {
        try {
            if (! isset($jobPositionData['id'])) {
                $jobPosition = new ANSH_Shared_Model_Entity_JobPositions();
                $jobPosition->setCreatedDate(new \DateTime());
            } else {
                $jobPosition = $this->getJobPositionById($jobPositionData['id']);
            }
            $jobPosition->setPosition(
                    $jobPositionData['jobPositionName']);
            $jobPosition->setIsEnabled(TRUE);
            $jobPosition->setDescription('add in future');
            $this->_em->persist($jobPosition);
            $this->_em->flush();
            return $jobPosition->getId();
        } catch (Exception $e) {
            $this->errors =  $e->getMessage();
            return FALSE;
            
        }
    }
    
    // get job position by id
    public function getJobPositionById ($jobPositionId)
    {
        return $this->_jobPositionObject->find($jobPositionId);
    }
    
    // get All job positions
    public function getAllJobPositionData ($page = NULL)
    {
        return $jobPositionData = $this->_jobPositionObject->findAll();
        
        // zend pagination factory object
        $paginatorData = Zend_Paginator::factory($jobPositionData);
        $paginatorData->setItemCountPerPage(5);
        $paginatorData->setCurrentPageNumber($page);
        return $paginatorData;
    }
}
