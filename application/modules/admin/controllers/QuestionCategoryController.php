<?php

/**
 * Question Category Controller in admin module for manage question categories
 */
class Admin_QuestionCategoryController extends Zend_Controller_Action
{

    protected $_categoryMapper = null;

    public $flashMessenger = null;

    /**
     * initialize categoryMapper,flashMessanger helper to use in entire class
     */
    public function init ()
    {
        // check ajax request then disable layout for all action
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        //initialize flash messenger for use in controller action
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        //initialize question category mapper for use in more than 1 action 
        $this->_categoryMapper = new Admin_Model_QuestionCategoryMapper();
    }

    // forward action to list action
    public function indexAction ()
    {
        $this->_forward('list');
    }
    
    // list out all question categories
    public function listAction ()
    {
        // get all question categories
        $this->view->categories = $this->_categoryMapper->getAllCategories(
                $this->getParam('page'), TRUE);
    }
    
    // add a new question category
    public function addAction ()
    {
        try {
            // initialize question category form
            $form = new Admin_Form_Questioncategory();
            $_request = $this->getRequest();
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                $data = $_request->getPost();
                
                // check valid data or return to form
                $validCategoryData = $form->getValidValues($data);
                if ($form->isValid($data)) {
                    
                    //checks image added or not if yes then add image name in $validCategoryData array to store in database.
                    if (isset($form->categoryImage)) {
                        $validCategoryData['categoryImage'] = $form->categoryImage->getValue();
                    }
                    
                    // checks category inserting or not
                    if ($this->_categoryMapper->save($validCategoryData)) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Question category added successfully!'
                                ));
                        $this->_redirect('admin/question-category/list');
                    } else {
                        $this->flashMessenger->addMessage(
                                array(
                                        'error' => 'Something goes wrong please try again!'
                                ));
                        $this->_redirect($_request->getHeader('referer'));
                    }
                }
                $form->populate($validCategoryData);
            }
            $this->view->categoryForm = $form;
        } catch (Exception $e) {
            echo ($e->getMessage());
            exit();
        }
    }
    
    // edit existing category
    public function editAction ()
    {
        try {
            
            $_request = $this->getRequest();
            
            $categoryId = $_request->getParam('categoryId');
            
            // get category data from category Id
            $validCategoryData = $this->_categoryMapper->getCategoryById(
                    $categoryId);
            // initialize question category form and set values to elements
            $form = new Admin_Form_Questioncategory($validCategoryData);
            $form->categoryName->removeValidator(
                    'ANSH_Resources_Validators_NoDbRecordExist');
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                $data = $_request->getPost();
                // check valid data or return to form
                $validCategoryData = $form->getValidValues($data);
                
                if ($form->isValid($data)) {
                    
                    //get value of image if uploded
                    if (isset($form->categoryImage)) {
                        
                        $validCategoryData['categoryImage'] = $form->categoryImage->getValue();
                    }
                    $validCategoryData['id'] = $categoryId;
                    
                    // checks user inserting or not
                    $result = $this->_categoryMapper->save($validCategoryData);
                    
                    if ($result) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Question category updated successfully!'
                                ));
                        $this->_redirect('admin/question-category/list');
                    } else {
                        $this->flashMessenger->addMessage(
                                $this->_categoryMapper->getErrors());
                        $this->_redirect($_request->getHeader('referer'));
                    }
                }
                
                $form->populate($validCategoryData);
            }
            $this->view->categoryForm = $form;
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
    
    // delete a question category
    public function deleteAction ()
    {
        try {
            $categoryId = $this->getParam('categoryId');
            $questionMapper = new Admin_Model_QuestionMapper();
            if (count($questionMapper->getQuestionsByCategoryId($categoryId))) {
                $this->flashMessenger->addMessage(
                        array(
                                'error' => "You can not delete this category!"
                        ));
            } else {
                $this->flashMessenger->addMessage(
                        array(
                                'success' => "Category successfully deleted!"
                        ));
                $result = $this->view->result = $this->_categoryMapper->deleteCategory(
                        $categoryId);
            }
            $this->_redirect('admin/question-category/list');
        } catch (Exception $e) {
            $result = $this->view->result = $e->getMessage();
        }
        return $this->_helper->json($result);
    }
    
    // delete category image ajax call
    public function deleteCategoryImageAction ()
    {
        try {
            $result = $this->_categoryMapper->deleteCategoryImage(
                    $this->getParam('categoryId'));
        } catch (Exception $e) {
            echo $result = $e->getMessage();
        }
        return $this->_helper->json($result);
    }
}
