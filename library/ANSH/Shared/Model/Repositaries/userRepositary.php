<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Doctrine\ORM\EntityRepository;

/**
 * userRepositary for manage user Enity Manager
 *
 * @author pramodkadam
 */
class ANSH_Shared_Model_Repositaries_userRepositary extends Doctrine\ORM\EntityRepository
{

    protected $_em;
    protected $_userRepositaryObject;

    public function __construct($em, $userRepositary)
    {
        $this->_em = $em;
        $this->_userRepositaryObject = $userRepositary;
    }

    /**
     * This function generates a salt key.
     * @return string - a uniquely generated value.
     */
    public static function generateSalt()
    {
        return (md5(uniqid(rand(), TRUE)));
    }

    /**
     * This function generates a password key.
     * @return string - a uniquely generated value.
     */
    public static function generatePassword()
    {
        $uniq = uniqid();
        $randomString = '';
        for ($i = 0; $i < 6; $i++) {
            $randomString .= $uniq[rand(0, strlen($uniq) - 1)];
        }
        return $randomString;
    }

    /**
     *
     * @param string $password - User's password
     * @param string $salt - A unique string
     * @return string - encrypted password
     */
    public static function encryptPassword($password, $salt)
    {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $password, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    public function save($userId, $firstName = NULL , $email = NULL , $password = NULL, $role =NULL)
    {
        try {
          
            if (is_null($userId)) {
                $user = new ANSH_Shared_Model_Entity_Users();
                if ($email !== NULL)
                $user->setEmail($email);
                $user->setPasswordSalt(self::generateSalt());
               
                $user->setIsEnabled(TRUE);
                $user->setCreatedDate(new \DateTime());
            } else {
                $user = $this->_userRepositaryObject->find($userId);
            }
            if ($firstName !== NULL)
            $user->setFullName($firstName);
             if ($password !== NULL)
                    $user->setPassword(self::encryptPassword($password, $user->getPasswordSalt()));
                
            $user->setModifiedDate(new \DateTime());
             if ($role !== NULL)
            $user->setRole($this->_em->getReference('ANSH_Shared_Model_Entity_Roles', $role));

            $this->_em->persist($user);
            $this->_em->flush();
            return $user;
        } catch (Exception $e) {
            echo $e->getMessage();
            throw new Exception($e->getMessage());
        }
    }

}
