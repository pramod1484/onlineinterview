<?php

/**
 * Form Technology for add new technology in admin module
 */
class Admin_Form_TechnologyForm extends Zend_Form
{

    private $_technologyData;

    /**
     *
     * @param type $technologyData
     *            constructure to initialize technologyData
     */
    public function __construct ($technologyData = NULL)
    {
        if ($technologyData != null)
            $this->_technologyData = $technologyData;
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
        $this->addElement('text', 'technologyName', 
                array(
                        'class' => 'form-control',
                        'autofocus' => 'autofocus',
                        'validators' => array(
                                new ANSH_Resources_Validators_NoDbRecordExist(
                                        'technology', 'technology_name')
                        ),
                        'Label' => 'Technology Name* : ',
                        'required' => true,
                        'filters' => array(
                                'StringToUpper'
                        ),
                        'value' => ($this->_technologyData) ? $this->_technologyData->getTechnologyName() : '',
                        'placeholder' => 'Enter Technology Name',
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
