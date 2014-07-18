<?php

/**
 * Helper Class to upload files.
 * @author Alankar More
 * 
 */
require_once 'Files.php';

class FileUpload extends Files
{
    private $_checkExtesion = true;
    
    private $_checkFileSize = true;
    
    /**
     * Initializing the posted file resource.
     * 
     * @param Resource $postFile
     */
    public function __construct(Array $inputs)
    {
        parent::__construct();
        $this->_files = $inputs['resource'][$inputs['objectName']];
        $this->_validExtensions = $inputs['extensions'];
    }
    
    /**
     * Function to upload file with necessary validations.
     */
    function uploadFile()
    {

        // Add our error codes to Master list
        $this->_defineErrorCodes();

        // Form method check
        if ( ( !isset($_SERVER['CONTENT_TYPE'])) ||
             ( strpos($_SERVER['CONTENT_TYPE'], 'multipart/form-data') !== 0) ) {
            return $this->_fileErrorCodes['UPLOAD_BAD_FORM'];
        }

        if ( empty ( $this->_files )) {
            return $this->_fileErrorCodes['UPLOAD_BAD_FORM'];
        }
 
        // check file is selected or not 
        $this->_fileName = $this->_getFileName();
        if ($this->_fileName != FALSE) {
            if ($this->_checkExtesion) {
                if ($this->isFileWithValidExtension()) {
                    if ($this->_checkFileSize) {
                        return $this->_moveFile();
                    }
                } 
            }
        } else {
            return $this->_fileErrorCodes['FILE_NOT_FOUND'];
        }
    }
    
    public function _defineErrorCodes() 
    {
        $this->_fileErrorCodes = &$this->_fileErrorCodes;
        $this->_fileErrorCodes['CONTENT_TYPE_MISMATCH'] = CONTENT_TYPE_MISMATCH;
        $this->_fileErrorCodes['FILE_NOT_FOUND'] = FILE_NOT_FOUND;                
        $this->_fileErrorCodes['BAD_EXTENSION'] = BAD_EXTENSION;                                
        $this->_fileErrorCodes['BAD_SIZE'] = BAD_SIZE;                                                
        $this->_fileErrorCodes['UNKNOWN_LOCATION'] = UNKNOWN_LOCATION;                                                
    }
    
    /**
     * Get file name which is uploaded by the user
     * 
     * @return mixed
     */
    protected function _getFileName() 
    {
        $this->_fileName = $this->_files['name'];

        return (!empty($this->_fileName)) ? $this->_fileName: FALSE;
    }
    
    /**
     * Set userd definded extensions
     * 
     * @param array $extensionArray
     */
    protected function _setExtensions($extensionArray) 
    {
        foreach ($extensionArray as $extension) {
            $this->_validExtensions[] = $extension;
        }
        
        $this->_checkExtesion = true;
    }
}