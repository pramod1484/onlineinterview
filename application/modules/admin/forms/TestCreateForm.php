<?php

/**
 * Form Test create for add new test in admin module
 */
class Admin_Form_TestCreateForm extends Zend_Form
{

    public $testName;

    public $categoryType;

    public $tecnnology;

    public $_testData;
    // common decorator for form element
    protected $_elementDecorators = array(
            array(
                    'ViewHelper',
                    array(
                            'class' => 'form-group'
                    )
            ),
            array(
                    'Label',
                    array(
                            'class' => 'col-sm-3  control-label text-danger'
                    )
            ),
            array(
                    'Errors',
                    array(
                            'class' => 'col-sm-12 help-block'
                    )
            )
    );
    // common decorator for form button element
    protected $_buttonDecorators = array(
            array(
                    'ViewHelper'
            )
    );

    /**
     *
     * @param type $testData
     *            constructer to initialize testdata
     */
    public function __construct ($testData = NULL)
    {
        if ($testData != null)
            $this->_testData = $testData;
        parent::__construct();
    }

    public function init ()
    {
        $this->setAction('')
            ->setMethod('post')
            ->setAttribs(array(
                'class' => 'form-horizontal',
                'id' => "testForm"
        ));
        $elements[] = $this->testName = new Zend_Form_Element_Text('testName', 
                array(
                        'autofocus' => true,
                        'class' => 'form-control'
                ));
        $this->testName->setRequired(TRUE)
            ->setLabel('Test Name* : ')
            ->setDecorators($this->_elementDecorators)
            ->setFilters(array(
                'stringToUpper'
        ))
            ->setValidators(
                array(
                        new ANSH_Resources_Validators_NoDbRecordExist('tests', 
                                'test_name')
                ));
        
        $elements[] = $this->categoryType = new Zend_Form_Element_Multiselect(
                'category', array(
                        'class' => 'form-control'
                ));
        $this->categoryType->setLabel('Categories* : ')
            ->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getCategoriesOptions(
                        FALSE))
            ->setDecorators($this->_elementDecorators)
            ->setRequired(true);
        
        $elements[] = $this->technology = new Zend_Form_Element_Select(
                'technology', array(
                        'class' => 'form-control'
                ));
        $this->technology->setDecorators($this->_elementDecorators)
            ->setRequired(TRUE)
            ->setLabel('Technology* : ')
            ->setErrorMessages(array(
                'Technology Should be Selected'
        ))
            ->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getTechnologies());
        
        $elements[] = $submit = new Zend_Form_Element_Submit('Save', 
                array(
                        'class' => 'btn btn-success'
                ));
        $submit->setDecorators($this->_buttonDecorators);
        
        $elements[] = $reset = new Zend_Form_Element_Reset('Reset', 
                array(
                        'class' => 'btn btn-warning'
                ));
        $reset->setDecorators($this->_buttonDecorators);
        
        $elements[] = $cancel = new Zend_Form_Element_Button('Cancel', 
                array(
                        'class' => 'cancel btn btn-danger'
                ));
        $cancel->setDecorators($this->_buttonDecorators);
        if ($this->_testData) {
            $this->setFieldValues();
        }
        
        $this->addElements($elements);
    }
    
    // set values to form elements
    private function setFieldValues ()
    {
        $this->testName->setValue($this->_testData->getTestName())
            ->removeValidator('ANSH_Resources_Validators_NoDbRecordExist');
        $this->technology->setValue($this->_testData->getTechnology()
            ->getId());
        $this->categoryType->setValue($this->_testData->categories);
    }
}
