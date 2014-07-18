<?php

/**
 * userpartial form for add new user in admin module,create candidate and can be used in candidate profile edit
 */
class Admin_Form_UserPartial extends Zend_Form
{

    public $fullName;

    public $email;

    public $roleId;

    public $submit;
    
    public $oldPassword;
    
    public $newPassword;

    public $confNewPassword;
    
    protected $_buttonDecorators = array(
            array(
                    'ViewHelper'
            )
    );

    public $_requiredFieldElementDecorators = array(
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
     public $_elementDecorators = array(
            array(
                    'ViewHelper',
                    array(
                            'class' => 'form-group'
                    )
            ),
            array(
                    'Label',
                    array(
                            'class' => 'col-sm-4  control-label'
                    )
            ),
            array(
                    'Errors',
                    array(
                            'class' => 'col-sm-12 help-block'
                    )
            )
    );
    public function init ()
    {
        $textBoxRegex = new Zend_Validate_Regex('/^[^<>\/;`%]*$/');
        $textBoxRegex->setMessages(
                array(
                        Zend_Validate_Regex::NOT_MATCH => 'Invalid Charecters.'
                ));
        
        $this->setAction('')
            ->setMethod('post')
            ->setAttribs(
                array(
                        'class' => 'form-horizontal',
                        'id' => "defaultForm"
                ));
        
        $this->fullName = new Zend_Form_Element_Text('fullName', 
                array(
                        'class' => 'form-control',
                        'autofocus' => true,'autocomplete' => 'off'
                ));
        $this->fullName->setAttribs(
                array(
                        'maxlength' => 100,
                        'placeholder' => 'Enter Name'
                ))
            ->setLabel('Name* :')
            ->setDecorators($this->_requiredFieldElementDecorators)
            ->setRequired(TRUE)
            ->addValidators(array(
                $textBoxRegex
        ), TRUE)
            ->addFilters(array(
                'StripTags',
                'StringTrim',
                'HtmlEntities'
        ));
        
        $this->email = clone $this->fullName;
        $this->email->setName('email')
            ->setLabel('Email* :')
            ->setAttribs(
                array(
                        'maxlength' => 100,
                        'placeholder' => 'Enter Email Address'
                ));
        
        $this->roleId = new Zend_Form_Element_Hidden('roleId');
        $this->roleId->setRequired(true)
            ->setValue(1)
            ->addValidator(new Zend_Validate_NotEmpty());
        
        $this->email->addValidators(
                array(
                        array(
                                'EmailAddress',
                                true
                        ),
                        new ANSH_Resources_Validators_NoDbRecordExist('users', 
                                'email')
                ))->setAttrib('maxlength', 255);
     $this->oldPassword = new Zend_Form_Element_Password('oldPassword', 
                array(
                        'class' => 'form-control',
                        'autofocus' => true,'autocomplete' => 'off'
                ));
        $this->oldPassword->setAttribs(
                array(
                        'placeholder' => 'Enter old password'
                ))->setLabel('Old Password* :')
            ->setDecorators($this->_requiredFieldElementDecorators)
            ->setRequired(TRUE)->addFilters(array(
                'StripTags',
                'StringTrim',
                'HtmlEntities'
        ));
           $this->newPassword = clone $this->oldPassword;
        $this->newPassword->setName('newPassword')
            ->setLabel('New password* :')
            ->setAttribs(
                array(
                        'placeholder' => 'Enter new password'
                ))
            ->addValidators(array(new Zend_Validate_StringLength(array('min' => 5 ,'max' => 10 ))));
        $this->confNewPassword = clone $this->newPassword;
        $this->confNewPassword->setName('confNewPassword')
            ->setLabel('Confirm new password* :')
            ->setAttribs(
                array(
                        'minlength' => 6,
                        'maxlength' => 10,
                        'placeholder' => 'Confirm new password'
                ))->addValidator('Identical', false, array('token' => 'newPassword'));
                $this->oldPassword->addValidators(array(
                $textBoxRegex , new ANSH_Resources_Validators_checkDbPassword,
        ), TRUE);
        
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
        $cancel = new Zend_Form_Element_Button('Cancel', 
                array(
                        'class' => 'cancel btn btn-danger'
                ));
        $cancel->setDecorators($this->_buttonDecorators);
        $this->addElements(
                array(
                        $this->fullName,
                    $this->oldPassword,
                    $this->confNewPassword,
                    $this->newPassword,
                        $this->email,
                        $this->roleId,
                        $submit,
                        $reset,$cancel
                ));
    }
}
