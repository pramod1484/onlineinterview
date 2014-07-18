<?php

/**
 * Form Question category for add new category in admin module
 */
class Admin_Form_Questioncategory extends Zend_Form
{

    public $categoryName;

    public $timeToFinishCategory;

    public $categoryImage;

    private $_categoryData = NULL;

    /**
     *
     * @param type $categoryData
     *            con structure to initialize categoryData
     */
    public function __construct ($categoryData = NULL)
    {
        if ($categoryData != null)
            $this->_categoryData = $categoryData;
        parent::__construct();
    }

    public function init ()
    {
        $this->setAction('')
            ->setMethod('post')
            ->setAttribs(
                array(
                        'id' => 'categoryForm',
                        'class' => 'form-horizontal'
                ))
            ->setEnctype('multipart/form-data');
        // common decorator for form input elements
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
        $requiredFiledElementDecorators = array(
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
        // common decorator for form button elements
        $buttonDecorators = array(
                array(
                        'ViewHelper'
                )
        );
        $emptyValidator = array(
                new Zend_Validate_NotEmpty(),
                TRUE
        );
        $this->categoryName = new Zend_Form_Element_Text('categoryName', 
                array(
                        'placeholder' => 'Enter Category Name',
                        'autofocus' => 'autofocus',
                        'class' => 'form-control'
                ));
        $this->categoryName->setAllowEmpty(FALSE)
            ->setLabel('Category Name* : ')
            ->setValidators(
                array(
                        $emptyValidator,
                        new ANSH_Resources_Validators_NoDbRecordExist(
                                'QuestionCategories', 'category_name')
                ))
            ->setDecorators($requiredFiledElementDecorators);
        
        $this->timeToFinishCategory = clone $this->categoryName;
        $this->timeToFinishCategory->setName('timeToFinish')
            ->setAttribs(
                array(
                        'placeholder' => 'Enter time to finish for category'
                ))
            ->setLabel('Time to finish* : ')
            ->addValidators(
                array(
                        array(
                                new Zend_Validate_Digits(),
                                true
                        ),
                        new Zend_Validate_Between(
                                array(
                                        'min' => 5,
                                        'max' => 120
                                ))
                ));
        
        $this->categoryImage = $this->createElement('file', 'categoryImage', 
                array(
                        'value' => 'Select image',
                        'class' => ''
                ));
        $this->categoryImage->addValidators(
                array(
                        array(
                                new Zend_Validate_File_Extension(
                                        array(
                                                'jpg',
                                                'gif',
                                                'png'
                                        )),
                                TRUE
                        ),
                        new Zend_Validate_File_Size(
                                array(
                                        'min' => '28KB',
                                        'max' => '1MB'
                                ))
                ))
            ->removeDecorator('label')
            ->removeDecorator('HtmlTag')
            ->addFilter(
                new Zend_Filter_File_Rename(
                        array(
                                'target' => CATEGORY_IMAGE,
                                'overwrite' => false
                        )))
            ->setDecorators(
                array(
                        array(
                                'File',
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
                ))
            ->setDestination(CATEGORY_IMAGE);
        
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
        
        if ($this->_categoryData) {
            $this->setFieldValues();
        }
        $this->addElements(
                array(
                        $this->categoryName,
                        $this->timeToFinishCategory,
                        $this->categoryImage,
                        $submit,
                        $reset,
                        $cancel
                ));
    }
    
    // set values to form element in edit form
    private function setFieldValues ()
    {
        $id = $this->createElement('hidden', 'id');
        $id->setAllowEmpty(false);
        $id->setValue($this->_categoryData->getId());
        $this->addElement($id);
        $this->categoryName->setValue($this->_categoryData->getCategoryName());
        $this->timeToFinishCategory->setValue(
                (int) $this->_categoryData->getTimeToFinish());
        if ($this->_categoryData->getCategoryImage() != NULL) {
            $view = Zend_Layout::getMvcInstance()->getView();
            $this->categoryImage = $this->createElement('hidden', 
                    'categoryImage');
            $this->categoryImage->setValue(
                    $this->_categoryData->getCategoryImage());
        }
    }
}
