<?php

/**
 * userMapper model to communicate doctrine mapper and admin user controller
 */
class Admin_Model_UserMapper
{

    protected $_em;

    protected $_userDoctrineOb;

    protected $_repositary;

    private $errors = '';
     
    /**
     * constructor initialize entityManager , userTableEntity and repository
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_userDoctrineOb = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_Users');
        $this->_repositary = new ANSH_Shared_Model_Repositaries_userRepositary(
                $this->_em, $this->_userDoctrineOb);
    }

    /**
     *
     * @param
     *            type array $userData
     * @return type boolean
     *         save new and update existing admin users;
     */
    public function save ($userData)
    {
        try {
            $password = (! isset($userData['newPassword']))?NULL:$userData['newPassword'];
            // checks id set or not
            if (! isset($userData['id'])) {
                $userData['id'] = NULL;
                $password = isset($userData['newPassword'])?$userData['newPassword']:$this->_repositary->generatePassword();
            }
            
            $userData = $this->_repositary->save($userData['id'], 
                    isset($userData['fullName'])?$userData['fullName']:NULL, isset($userData['email'])?$userData['email']:NULL, $password, 
                    isset($userData['roleId'])?$userData['roleId']:NULL);
            $userData->newpassword = $password;
            return $userData;
        } catch (Exception $e) {
            $this->errors =  $e->getMessage();
            return FALSE;
        }
    }

    /**
     *
     * @param
     *            type integer $page
     * @return type Zend pagination data
     *         get All admin users
     */
    public function getAllUsers ($page = NULL )
    {
        $querybBuilder = $this->_em->createQueryBuilder();
        $querybBuilder->select(
                array(
                        'partial u.{id, fullName ,email , isEnabled }'
                ))
            ->from('ANSH_Shared_Model_Entity_Users', 'u')
            ->where(
                $querybBuilder->expr()
                    ->orX($querybBuilder->expr()
                    ->eq('u.role', ':id')))
            ->setParameter('id', 1);
        $query = $querybBuilder->getQuery();
        return $usersAllData = $query->getArrayResult();
        
        // zend pagination factory object
        // $paginatorData = Zend_Paginator::factory($usersAllData);
        // $paginatorData->setItemCountPerPage(5);
        // $paginatorData->setCurrentPageNumber($page);
        // return $paginatorData;
    }

    /**
     *
     * @param type $userId            
     * @return type array userdetails
     *         get userdetails by id
     */
    public function getUserById ($userId)
    {
        $user = $this->_userDoctrineOb->find($userId);
        return $userDetails = array(
                'fullName' => $user->getFullName(),
                'email' => $user->getEmail(),
                'roleId' => $user->getRole()->getId()
        );
    }

    /**
     *
     * @param type $userId            
     * @return type boolean;
     *         delete userby Id
     */
    public function deleteUserById ($userId)
    {
        try {
            $user = $this->_userDoctrineOb->find($userId);
            $this->_em->remove($user);
            $this->_em->flush();
            return $user;
        } catch (Exception $e) {
            echo $e->getMessage();
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
