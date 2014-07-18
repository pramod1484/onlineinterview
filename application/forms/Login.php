<?php

class Application_Form_Login extends Zend_Form
{

    private $requestUrl;

    public function __construct ($url)
    {
        if ($url != NULL)
            $this->requestUrl = $url;
        parent::__construct();
    }

    public function init ()
    {
        // Custom decorator for frm fields
        $elementDecorators = array(
                array(
                        'ViewHelper'
                ),
                array(
                        'Label',
                        array(
                                'tag' => 'div',
                                'class' => 'control-label',
                                'requiredSuffix' => '<span class="form-required">*</span>',
                                'escape' => false
                        )
                ),
                array(
                        'Errors',
                        array(
                                'class' => 'help-block'
                        )
                )
        );
        $buttonDecorators = array(
                array(
                        'ViewHelper'
                )
        );
        $this->setMethod('post')
            ->setAction(
                $this->getView()
                    ->url(
                        array(
                                'module' => 'default',
                                'controller' => 'login',
                                'action' => 'index'
                        )))
            ->setName('Login');
        
        // Email
        $email = new Zend_Form_Element_Text('email', 
                array(
                        'placeholder' => 'Enter Email Id',
                        'class' => 'form-control'
                ));
        $email->setLabel('Email')
            ->setDecorators($elementDecorators)
            ->setRequired(TRUE)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addFilter('StringToLower')
            ->addValidator('NotEmpty', TRUE)
            ->addValidator('EmailAddress', TRUE);
        
        // Password
        $password = new Zend_Form_Element_Password('password', 
                array(
                        'placeholder' => 'Enter the Password',
                        'class' => 'form-control','autocomplete' => 'off'
                ));
        $password->setLabel('Password')
            ->setDecorators($elementDecorators)
            ->setRequired(TRUE)
            ->addFilter('StripTags')
            ->addFilter('StringTrim')
            ->addValidator('NotEmpty');
        
        $hash = new Zend_Form_Element_Hash('csrf', array(
                'salt' => 'unique'
        ));
        $hash->setTimeout(50)->addErrorMessage(
                'Form timed out. Please reload the page & try again');
        
        $rememberMe = new Zend_Form_Element_Checkbox('remember');
        $rememberMe->setDecorators($elementDecorators);
        // Submit
        $submit = new Zend_Form_Element_Submit('login', 
                array(
                        'class' => "btn btn-primary",
                        'value' => 'Sign in'
                ));
        $submit->setDecorators($buttonDecorators);
        
        if ($this->requestUrl) {
            $hiddenRequest = new Zend_Form_Element_Hidden('requestUrl');
            $hiddenRequest->setValue($this->requestUrl)->removeDecorator('label')->removeDecorator('htmlTag');
            $this->addElement($hiddenRequest);
        }
        // Create
        $this->addElements(array(
                $email,
                $password,
                $rememberMe,
                $submit
        ));
    }
}
