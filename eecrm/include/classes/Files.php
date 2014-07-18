<?php

error_reporting(E_ALL);
ini_set('dispaly_errors',1);
/*
 * This class will provide all basic operations related to the files.
 */
require_once 'error-codes.php';

class Files
{
    /**
     * The file resource uploaded by the user
     * 
     * @var resource 
     */
    protected $_files;
    
    protected  $_fileName;
    
    protected $_fileExtension;
    
    protected $_validExtensions = array();

    /**
     *
     * @var errorcodes related to the files 
     */
    protected $_fileErrorCodes = array();
    
    public function __construct()
    {
        $this->_defineErrorCodes();
    }
    /**
     * Defining error codes.
     */
    public function _defineErrorCodes()
    {
        $this->_fileErrorCodes['LOCATION_NOT_WRITABLE'] = LOCATION_NOT_WRITABLE;                                                
        $this->_fileErrorCodes['FILE_NOT_WRITABLE'] = FILE_NOT_WRITABLE;                                                
        $this->_fileErrorCodes['FILE_NOT_READABLE'] = FILE_NOT_READABLE;   
    }
    
    /**
     * Get file extension for the file name provided by the user 
     * 
     * @return string
     */
    protected function getFileExtension() 
    {
        return strtolower(pathinfo($this->_fileName,PATHINFO_EXTENSION));
    }
    
    /**
     * Check is file is with the validat extension as per the extensions 
     * provided by the user 
     * 
     * @return bool
     */
    protected function isFileWithValidExtension() 
    {
        $this->_fileExtension = $this->getFileExtension();
        
        return in_array($this->_fileExtension, $this->_validExtensions);
    }
    
    protected function _moveFile()
    {
        try {
            move_uploaded_file($this->_files['tmp_name'],dirname(__DIR__)."/../data/upload/".$this->_files['name']);
            
            return $this->_fileName;
        } catch (Exception $exc) {
            return $exc->getMessage();
        }
    }
}