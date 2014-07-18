<?php

/**
 * QuestionType Master for communicate with QuestionType doctrine Entity
 */
class Admin_Model_QuestionTypeMapper
{

    /**
     *
     * @var type Entity Manager Object
     */
    protected $_em;

    /**
     *
     * @var type QuestionType doctrine entity
     */
    protected $_questionTypeObject;

    /**
     * constructor initialize entityManager , QuestionTypesTableEntity
     */
    public function __construct ()
    {
        $this->_em = \Zend_Registry::get('entityManager');
        $this->_questionTypeObject = $this->_em->getRepository(
                'ANSH_Shared_Model_Entity_QuestionTypes');
    }
    
    // get All question types
    public function getAllQuestionTypes ()
    {
        return $this->_questionTypeObject->findAll();
    }
}
