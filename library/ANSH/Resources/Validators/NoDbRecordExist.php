<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Custom validator to check record already exist in database
 *
 * @author pramodkadam
 */
class ANSH_Resources_Validators_NoDbRecordExist extends Zend_Validate_Abstract
{

    private $_table;
    private $_field;
    protected $_em;

    const OK = '';

    protected $_messageTemplates = array(
        self::OK => "'%value%' is already Exist in database"
    );

    /**
     * 
     * @param type $table as string
     * @param type $field as string
     */
    public function __construct($table, $field)
    {
        try{
        $this->_em = Zend_Registry::get('entityManager');
        $tableName = "ANSH_Shared_Model_Entity_" . $table;
        $this->_table = $this->_em->getRepository($tableName);
        $this->_field = $field;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    /**
     * validate for duplicate entry
     * @param type $value as mixed
     * @return boolean
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        $funcName = 'findBy' . $this->_field;

        if (count($this->_table->$funcName($value)) > 0) {
            $this->_error(self::OK);
            return false;
        }

        return true;
    }

}
