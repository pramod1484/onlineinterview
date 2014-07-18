<?php

/**
 * Candidate mapper for communicate with doctrine candidate entity
 */
class Admin_Model_CandidateMapper
{

    /**
     *
     * @var type EntityManager
     *      doctrine entity Manger
     */
    protected $_em;

    /**
     *
     * @var type Entity
     *      doctrine candidate entity
     */
    protected $_candidateDoctrineOb;

    /**
     *
     * @var type string
     */
    private $errors = '';

    /**
     * constructor initialize entityManager , candidatesTableEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_candidateDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_Candidates');
    }
    
    // save candidate
    public function save ($candidateData)
    {
        try {
            $this->_em->beginTransaction();
            
            $user = new Admin_Model_UserMapper();
            
            // add new user or edit and get uswr data
            if ($newUser = $user->save($candidateData)) {
                
                // checks existing candidate or new
                if (! isset($candidateData['id'])) {
                    $candidate = new ANSH_Shared_Model_Entity_Candidates();
                    $candidate->setCreatedDate(new DateTime());
                } else {
                    $candidate = $this->getCandidateByCandidateId(
                            $newUser->getId());
                }
                
                $candidate->setUser(
                        $this->_em->getReference(
                                'ANSH_Shared_Model_Entity_Users', 
                                $newUser->getId()));
                $candidate->setJobPosition(
                        $this->_em->getReference(
                                'ANSH_Shared_Model_Entity_JobPositions', 
                                $candidateData['position']));
                $candidate->setDateOfBirth(
                        new DateTime($candidateData['birthDate']));
                $this->_em->persist($candidate);
                $this->_em->flush();
                
                $candidateTest = new Admin_Model_CandidateTestMapper();
                // geting result test created or not used to rollback or
                // commit entire transaction
                $result = $candidateTest->save($candidate->getId(), 
                        $candidateData['test']);
                
                // throw exception on candidate test save occurs error
                if (! $result) {
                    throw new Exception($candidateTest->getErrors());
                }
                $this->_em->commit();
                return $newUser;
            }
        } catch (Exception $e) {
            $this->errors = $e->getMessage();
            // rollback transaction on error
            $this->_em->rollback();
            return FALSE;
        }
    }
    
    // save candidate profile
    public function saveProfile ($candidateData)
    {
        try {
            $this->_em->beginTransaction();
            $user = new Admin_Model_UserMapper();
            try {
                
                if ($newUser = $user->save($candidateData)) {
                    
                    if (! isset($candidateData['id']) ||
                             (NULL ===
                             $this->getCandidateByCandidateId($newUser->getId()))) {
                        $candidate = new ANSH_Shared_Model_Entity_Candidates();
                        $candidate->setCreatedDate(new DateTime());
                    } else {
                        $candidate = $this->getCandidateByCandidateId(
                                $newUser->getId());
                    }
                    $candidate->setUser(
                            $this->_em->getReference(
                                    'ANSH_Shared_Model_Entity_Users', 
                                    $newUser->getId()));
                    $candidate->setDateOfBirth(
                            new DateTime($candidateData['birthDate']));
                    $candidate->setDegree($candidateData['degree']);
                    $candidate->setExperience($candidateData['experienceYears'] . "." .$candidateData['experienceMonths']);
                    $candidate->setNoticePeriod($candidateData['noticePeriod']);
                    $candidate->setLocality($candidateData['locality']);
                    $candidate->setCity($candidateData['city']);
                    $candidate->setMobileNo($candidateData['mobileNo']);
                    $this->_em->persist($candidate);
                    $this->_em->flush();
                }
            } catch (Exception $e) {
                echo $e->getMessage();
                $this->_em->rollback();
                return FALSE;
            }
            // on successfull transaction commit and return candidate
            $this->_em->commit();
            return $candidate;
        } catch (Exception $e) {
            echo $e->getMessage();
            return FALSE;
        }
    }

    /**
     *
     * @param type $candidateId            
     * @return type object Candidate
     *         get candidate details by it's it
     */
    public function getCandidateById ($candidateId)
    {
        $candidate = $this->_candidateDoctrineOb->find($candidateId);
        if ($candidate !== NULL)
            $candidate->test = $this->getCandidateTest($candidate->getId());
        return $candidate;
    }

    /**
     *
     * @param type $candidateuserId            
     * @return type object Candidate
     *         get candidate details by it's it
     */
    public function getCandidateByCandidateId ($candidateUserId)
    {
        $candidate = $this->_candidateDoctrineOb->findOneBy(
                array(
                        'user' => $candidateUserId
                ));
        if ($candidate !== NULL)
            $candidate->test = $this->getCandidateTest($candidate->getId());
        return $candidate;
    }

    /**
     *
     * @param type $candidateId            
     * @return type integer
     *         get test assigned to candidate
     */
    public function getCandidateTest ($candidateId)
    {
        $candidateTestMapper = new Admin_Model_CandidateTestMapper();
        $test = $candidateTestMapper->getCatndidateTestByCandidateId(
                $candidateId);
        return ($test) ? $test->getTest() : '';
    }

    /**
     *
     * @param type $page            
     * @return type $paginationData
     *        
     *         get All candidated details
     */
    public function getAllCandidates ($page = NULL, $fromDate = NULL, $toDate = NULL)
    {
        try {
            
        
        $queryBuilder = $this->_em->createQueryBuilder();
        $queryBuilder->select('c')->from('ANSH_Shared_Model_Entity_Candidates', 
                'c');
        
        if ($fromDate != NULL && $toDate != NULL) {
            
                $queryBuilder->andWhere(
                        $queryBuilder->expr()
                            ->orx(
                                $queryBuilder->expr()
                                    ->between('c.createdDate', '?1','?2'))

                        );
                 $queryBuilder->setParameter(1, $fromDate);
                $queryBuilder->setParameter(2, $toDate);
            
            
        }
        $queryBuilder->orderBy('c.createdDate', 'DESC');
        $query = $queryBuilder->getQuery();
        $candidatesAllData = $query->getResult();
        foreach ($candidatesAllData as $key => $candidate) {
            $candidate->test = $this->getCandidateTest($candidate->getId());
        }
        // zend pagination factory object
        // $paginatorData = Zend_Paginator::factory($candidatesAllData);
        // $paginatorData->setItemCountPerPage(5);
        // $paginatorData->setCurrentPageNumber($page);
        return $candidatesAllData;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }

    }

    public function deleteCandidateById ($candidateId)
    {
        try {
            $candidateMapper = new Admin_Model_CandidateTestMapper();
            $result = $candidateMapper->getCatndidateTestByCandidateId(
                    $candidateId);
            
            if ($result) {
                $this->errors =  'You can not delete this candidate test already assigned!';
                return FALSE;
            }
            $candidate = $this->getCandidateById($candidateId);
            $candidateName = $candidate->getUser()->getFullName();
            $this->_em->remove($candidate);
            $this->_em->flush();
            $userMapper = new Admin_Model_UserMapper();
            $user = $userMapper->deleteUserById(
                    $candidate->getUser()
                        ->getId());
            $this->_em->remove($user);
            $this->_em->flush();
            return $candidateName;
        } catch (Exception $e) {
            echo $e->getMessage();
            exit();
        }
    }

    public function getCandidateCount ($lastweek = FALSE)
    {
        try {
            
            $queryBuilder = $this->_em->createQueryBuilder();
            $queryBuilder->select('COUNT(c)')->from(
                    'ANSH_Shared_Model_Entity_Candidates', 'c');
            if ($lastweek == TRUE) {
                $date = new \DateTime();
                $date = date_modify(new DateTime(), '-1 week')->format('Y-m-d');
                $queryBuilder->where('c.createdDate >  ?1');
                $queryBuilder->setParameter(1, $date);
            }
            $query = $queryBuilder->getQuery();
            return $query->getSingleScalarResult();
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
	/**
	 * @return the $errors
	 */
	public function getErrors() {
		return $this->errors;
	}

	/**
	 * @param type $errors
	 */
	public function setErrors($errors) {
		$this->errors = $errors;
	}



}
