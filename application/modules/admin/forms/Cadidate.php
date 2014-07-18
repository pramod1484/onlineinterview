<?php

/**
 * form for add new candidate from admin module
 */
class Admin_Form_Cadidate extends Zend_Form
{

    public $roleId;

    public $position;

    public $test;

    public $dob;

    public $userPartialForm;

    protected $_candidateData;
    // common decorator for form input elements
    protected $_elementDecorators = array(
            array(
                    'ViewHelper',
                    array(
                            'class' => 'form-control'
                    )
            ),
            array(
                    'Label',
                    array(
                            'class' => 'col-sm-4  control-label text-danger'
                    )
            ),
            array(
                    'Errors',
                    array(
                            'class' => 'col-sm-12 help-block'
                    )
            )
    );
    // common decorator for button
    protected $_buttonDecorators = array(
            array(
                    'ViewHelper'
            )
    );

    protected $JQueryElements = array(
            array(
                    'UiWidgetElement',
                    array(
                            'class' => 'form-control'
                    )
            ), // it
               // necessary
               // to
               // include
               // for
               // jquery
               // elements
            array(
                    'Errors',
                    array(
                            'tag' => 'div',
                            'class' => 'col-sm-12 help-block'
                    )
            ),
            array(
                    'Description',
                    array(
                            'tag' => 'span'
                    )
            ),
            array(
                    'ViewHelper',
                    array(
                            'class' => 'form-control'
                    )
            ),
            array(
                    'Label',
                    array(
                            'class' => 'col-sm-4  control-label text-danger'
                    )
            )
    );

    /**
     *
     * @param type $categoryData
     *            con-structure checks candidate data available or not
     */
    public function __construct ($candidateData = NULL)
    {
        if ($candidateData != null)
            $this->_candidateData = $candidateData;
        parent::__construct();
    }

    public function init ()
    {
        $this->setAction('')
            ->setMethod('post')
            ->setAttribs(
                array(
                        'class' => 'form-horizontal',
                        'id' => "defaultForm"
                ));
        $this->userPartialForm = new Admin_Form_UserPartial();
        $elements = $this->userPartialForm->getElements();
        $elements[] = $this->roleId = clone $elements['roleId'];
        $this->roleId->setValue(2)->setAttribs(
                array(
                        'style' => 'display:none'
                ));
        
        $elements[] = $this->dob = new ZendX_JQuery_Form_Element_DatePicker(
                'birthDate', 
                array(
                        'placeholder' => ' Enter Date of Birth',
                        'class' => 'form-control',
                        'validators' => array(
                                'Date'
                        ),
                        'required' => true,
                        'jQueryParams' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => TRUE,
                                'changeYear' => TRUE,
                                'yearRange' => '1970:2013'
                        )
                ));
        $this->dob->setDecorators($this->JQueryElements);
        $elements[] = $this->position = new Zend_Form_Element_Select('position');
        $this->position->setAttrib('class', 'form-control')
            ->setRequired(TRUE)
            ->setDecorators($this->_elementDecorators)
            ->setLabel('Select Position* :')
            ->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getJobPositions());
        
        $elements[] = $this->test = clone $this->position;
        $this->test->setName('test')
            ->setLabel('Select Test* :')
            ->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getTests());
        
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
        if ($this->_candidateData) {
            
            $this->setFieldValues();
        }
        $this->addElements($elements);
    }

    /**
     * function for set values on edit candidate
     */
    function setFieldValues ()
    {
        $userMapper = new Admin_Model_UserMapper();
        $this->userPartialForm->populate(
                $userMapper->getUserById(
                        $this->_candidateData->getUser()
                            ->getId()));
        $this->position->setValue(
                $this->_candidateData->getJobPosition() ? $this->_candidateData->getJobPosition()
                    ->getId() : '');
        $this->test->setValue(
                ($this->_candidateData->test) ? $this->_candidateData->test->getId() : '');
        $this->dob->setValue(
                ($this->_candidateData->getDateOfBirth()) ? date_format(
                        $this->_candidateData->getDateOfBirth(), 'Y-m-d') : '');
    }
}
