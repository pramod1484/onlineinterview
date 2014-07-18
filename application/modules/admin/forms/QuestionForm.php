<?php

/**
 * Form for add,edit question from admin module
 */
class Admin_Form_QuestionForm extends Zend_Form
{

    public $categoryType;

    public $marks;

    public $question;

    public $questionType;

    public $textOptions;

    public $radio;

    public $checkBox;

    public $freeTextArea;

    public $freeTextBox;

    protected $_questionData;
    // common decorator for form input elements
    protected $_elementDecorators = array(
            array(
                    'ViewHelper'
            ),
            array(
                    'Label',
                 array(
                            'class' => 'text-danger'
                    )
            ),
            array(
                    'Errors',
                    array(
                            'class' => 'col-sm-12 help-block'
                    )
            )
    );
    // common decorator for button elements
    protected $_buttonDecorators = array(
            array(
                    'ViewHelper'
            )
    );

    /**
     *
     * @param type $questionData
     *            constructor to initialize questionData if available
     */
    public function __construct ($questionData = NULL)
    {
        if ($questionData != null)
            $this->_questionData = $questionData;
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
        $elements = array();
        $elements[] = $this->categoryType = new Zend_Form_Element_Select(
                'categoryId');
        $this->categoryType->setDecorators($this->_elementDecorators)
            ->setRequired(TRUE)
            ->setErrorMessages(array(
                'Category type should be selected'
        ))
            ->setAttrib('class', 'form-control')
            ->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getCategoriesOptions());
        
        $elements[] = $this->marks = clone $this->categoryType;
        
        $this->marks->setName('marks')
            ->setErrorMessages(array(
                'Marks should be selected'
        ))
            ->setMultiOptions($this->getMarks());
        
        $elements[] = $this->question = new Zend_Form_Element_Textarea(
                'question', array(
                        'class' => 'ckeditor'
                ));
        $this->question->setRequired(TRUE)->setDecorators(
                $this->_elementDecorators);
        
        $elements[] = $this->questionType = clone $this->categoryType;
        $this->questionType->setName('questionType')
            ->setErrorMessages(array(
                'Question type should be selected'
        ))
            ->setMultiOptions(
                ANSH_Resources_Helpers_CommonDropdownOptions::getQuestionTypes());
        
        $elements[] = $this->radio = new Zend_Form_Element_Radio('radioAnswer');
        $this->radio->setRequired(TRUE)
            ->setDecorators($this->_elementDecorators)
            ->setAttrib('class', 'radio');
        
        $elements[] = $this->checkBox = new Zend_Form_Element_MultiCheckbox(
                'checkBoxAnswer');
        $this->checkBox->setRequired(TRUE)
            ->setDecorators($this->_elementDecorators)
            ->setAttrib('class', 'checkbox');
        
        $elements[] = $this->freeTextArea = new Zend_Form_Element_Textarea(
                'freeTextArea', 
                array(
                        'cols' => 30,
                        'rows' => 5,
                        'placeholder' => 'Expected result.'
                ));
        $this->freeTextArea->setDecorators($this->_elementDecorators)
            ->setFilters(array(
                'StripTags',
                'StringTrim'
        ))
            ->setAttrib('class', 'form-control');
        
        $elements[] = $this->freeTextBox = new Zend_Form_Element_Text(
                'freeTextbox');
        $this->freeTextBox->setDecorators($this->_elementDecorators)->setAttribs(
                array(
                        'placeholder' => 'Expected result',
                        'class' => 'form-control'
                ));
        $elements[] = $question = clone $this->freeTextBox;
        $question->setName('searchKey');
        $this->getMultioptions(4);
        
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
        if ($this->_questionData) {
            $this->setFieldValues();
        }
        $this->addElements($elements);
    }

    private function getMarks ()
    {
        $marks = array(
                '' => 'Select Marks'
        );
        for ($i = '0.5'; $i <= 5; $i = $i + '0.5') {
            $marks[$i . ''] = '' . $i;
        }
        return (($marks));
    }

    /**
     *
     * @param type $no
     *            add multi option as per question type and qty
     */
    public function getMultioptions ($no)
    {
        for ($i = 1; $i <= $no; $i ++) {
            $this->textOptions = $this->createElement('Text', 'option' . $i, 
                    array(
                            'placeholder' => 'Enter option ' . $i,
                            'class' => 'options form-control',
                            'belongsTo' => 'options'
                    ))->setFilters(array(
                    'StripTags',
                    'StringTrim'
            ));
            if ($i <= 2) {
                $this->textOptions->setRequired(TRUE);
            }
            if ($this->_questionData) {
                $textOption = unserialize($this->_questionData->getOptions());
                $this->textOptions->setValue($textOption['option' . $i]);
            }
            
            $this->addElement($this->textOptions);
            $this->radio->addMultiOption('option' . $i);
            $this->checkBox->addMultiOption('option' . $i);
        }
    }
    
    // set values to form elements on edit question
    private function setFieldValues ()
    {
        $id = $this->createElement('hidden', 'id');
        $id->setAllowEmpty(false);
        $id->setValue($this->_questionData->getId());
        $this->addElement($id);
        $this->categoryType->setValue(
                $this->_questionData->getCategory()
                    ->getId());
        $this->marks->setValue($this->_questionData->getMarks());
        $this->question->setValue($this->_questionData->getQuestion());
        $this->questionType->setValue(
                $this->_questionData->getQuestionType()
                    ->getId());
        switch ($this->_questionData->getQuestionType()->getId()) {
            case '1':
                $this->checkBox->setValue(
                        unserialize($this->_questionData->getAnswers()));
                $this->radio->setRequired(FALSE);
                break;
            case '2':
                $this->radio->setValue(
                        unserialize($this->_questionData->getAnswers()));
                $this->checkBox->setRequired(FALSE);
                break;
            case '3':
                $this->freeTextArea->setValue(
                        unserialize($this->_questionData->getAnswers()));
                break;
            case '4':
                $this->freeTextBox->setValue(
                        unserialize($this->_questionData->getAnswers()));
                break;
        }
    }
}
