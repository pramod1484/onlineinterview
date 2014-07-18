<?php

class Admin_Form_JobPosition extends Zend_Form
{

   private $_jobPositionData;

    /**
     *
     * @param type $jobPositionData
     *            constructure to initialize jobPositionData
     */
    public function __construct ($jobPositionData = NULL)
    {
        if ($jobPositionData != null)
            $this->_jobPositionData = $jobPositionData;
        parent::__construct();
    }

    public function init ()
    {
        $elementDecorators = array(
                array(
                        'ViewHelper',
                        array(
                                'class' => 'form-group'
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
        $buttonDecorators = array(
                array(
                        'ViewHelper'
                )
        );
        $this->setAction('')
            ->setMethod('post')
            ->setAttribs(
                array(
                        'class' => 'form-horizontal',
                    ));
        $this->addElement('text', 'jobPositionName', 
                array(
                        'class' => 'form-control',
                        'autofocus' => 'autofocus',
                        'validators' => array(
                                array(
                                        'regex',
                                        false,
                                        '/^[a-z]/i'
                                ),
                                new ANSH_Resources_Validators_NoDbRecordExist(
                                        'jobPositions', 'position')
                        ),
                        'Label' => 'Job Position* : ',
                        'required' => true,
                        'filters' => array(
                                'StringToUpper'
                        ),
                        'value' => ($this->_jobPositionData) ? $this->_jobPositionData->getPosition() : '',
                        'placeholder' => 'Enter Job Position',
                        'decorators' => $elementDecorators
                ));
        
        $submit = new Zend_Form_Element_Submit('Save', 
                array(
                        'class' => 'btn btn-success'
                ));
        $submit->setDecorators($buttonDecorators);
        
        $reset = new Zend_Form_Element_Reset('Reset', 
                array(
                        'class' => 'btn btn-warning'
                ));
        $reset->setDecorators($buttonDecorators);
        
        $cancel = new Zend_Form_Element_Button('Cancel', 
                array(
                        'class' => 'cancel btn btn-danger'
                ));
        $cancel->setDecorators($buttonDecorators);
        $this->addElements(array(
                $submit,
                $reset,
                $cancel
        ));
    }

}

