<?php

/**
 * Question controller in admin module to manage questions for test
 */
class Admin_QuestionController extends Zend_Controller_Action
{

    protected $_questionMapper = null;

    public $flashMessenger = null;

    /**
     * initialize questionMapper,flashMessanger helper to use in entire class
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
        //initialize question mapper for use in more than 1 action
        $this->_questionMapper = new Admin_Model_QuestionMapper();
    }

    // forward action to list action
    public function indexAction ()
    {
        $this->_forward('list');
    }

    // list and view all questions
    public function listAction ()
    {
        // search options to list questions
        $form = new Admin_Form_QuestionForm();
        $validValues = $form->getValidValues($this->getAllParams());
        $form->populate($validValues);
        $this->view->questions = $this->_questionMapper->getAllQuestions(
                $this->getParam('page'), $validValues);
        $this->view->form = $form;
    }
    
    // add question
    public function addAction ()
    {
        try {
            $form = new Admin_Form_QuestionForm();
            $_request = $this->getRequest();
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                $data = $_request->getPost();
                
                // add validation on question type
                if ($data['questionType'] == 4 || $data['questionType'] == 3) {
                    $form->checkBox->setRequired(FALSE);
                    $form->radio->setRequired(FALSE);
                    for ($i = 1; $i <= 4; $i ++) {
                        $options = 'option' . $i;
                        
                        $form->$options->setRequired(FALSE);
                    }
                } else 
                    if ($data['questionType'] == 1) {
                        $form->radio->setRequired(FALSE);
                    } else 
                        if ($data['questionType'] == 2) {
                            $form->checkBox->setRequired(FALSE);
                        }
                // check valid data or return to form
                $validQuestionData = $form->getValidValues($data);
                
                //continue if form vaalidatin pass
                if ($form->isValid($data)) {
                    
                    // checks user inserting or not
                    if ($this->_questionMapper->save($validQuestionData)) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Question added successfully!'
                                ));
                        $this->_redirect('admin/question/list');
                    }
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => 'Something goes wrong please try again!'
                            ));
                    $this->_redirect($_request->getHeader('referer'));
                }
                $form->populate($validQuestionData);
            }
            $this->view->form = $form;
        } catch (Exception $e) {
            echo ($e->getMessage());            
        }
    }

    // edit existing question
    public function editAction ()
    {
        try {
            $_request = $this->getRequest();
            // get question data by question Id
            $validQuestionData = $this->_questionMapper->getQuestionById(
                    $this->_request->getParam('questionId'));
            
            // send question data to form
            $form = new Admin_Form_QuestionForm($validQuestionData);
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                $data = $_request->getPost();
                
                // adding validations as per queston type
                if ($data['questionType'] == 4 || $data['questionType'] == 3) {
                    $form->checkBox->setRequired(FALSE);
                    $form->radio->setRequired(FALSE);
                    for ($i = 1; $i <= 4; $i ++) {
                        $options = 'option' . $i;
                        
                        $form->$options->setRequired(FALSE);
                    }
                } else 
                    if ($data['questionType'] == 1) {
                        $form->radio->setRequired(FALSE);
                    } else 
                        if ($data['questionType'] == 2) {
                            $form->checkBox->setRequired(FALSE);
                        }
                // check valid data or return to form
                $validQuestionData = $form->getValidValues($data);
                
                if ($form->isValid($data)) {
                    
                    $validQuestionData['id'] = $this->_request->getParam('questionId');
                    // checks user inserting or not
                    if ($this->_questionMapper->save($validQuestionData)) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Question updated successfully!'
                                ));
                        $this->_redirect('admin/question/list');
                    } else {
                        $this->flashMessenger->addMessage(
                                array(
                                        'error' => $this->_questionMapper->getErrors()
                                ));
                        $this->_redirect($_request->getHeader('referer'));
                    }
                }
                $form->populate($validQuestionData);
            }
            $this->view->form = $form;
        } catch (Exception $e) {
            echo ($e->getMessage());
          }
    }

    // delete question
    public function deleteAction ()
    {
        $_request = $this->getRequest();
        $questionId = $this->getParam('questionId');
        
        // checking authorized request to avoid call from ajax
        if (! Zend_Auth::getInstance()->hasIdentity()) {
            $this->flashMessenger->addMessage(
                    array(
                            'error' => 'You can not have permission to delete!'
                    ));
        }
        
        // check user deleting or not
        if ($this->_questionMapper->deleteQuestionById($questionId) == 1) {
            $this->flashMessenger->addMessage(
                    array(
                            'success' => 'Question deleted successfully!'
                    ));
        } else {
            $this->flashMessenger->addMessage(
                    array(
                            'error' => 'Something goes wrong please try again!'
                    ));
        }
        $this->_redirect('admin/question/list');
    }

    //TODO remove this function or edit
    public function editorImageUploadAction ()
    {
        try{
        $message = "Success";
        // extensive suitability check before doing anything with the file…
      
        $funcNum = $_GET['CKEditorFuncNum'];
        
        
        if ($this->getRequest()->isPost()) {
  
    $upload = new Zend_File_Transfer_Adapter_Http();
  
    $upload->setDestination(QUESTION_IMAGE);
  
    $upload->addValidator('MimeType', false, array('image/gif', 'image/jpeg','image/png'))
            ->addValidator('Size', false, 500000);
   
   
    if ($upload->isValid()) {
   
      $upload->receive();
  
    } else {
   
        
       $message = array_shift($upload->getErrors());
    
    }
    $url = $this->view->baseUrl()."/uploads/questionImages/".$upload->getFileName(NULL,FALSE);
  }
        echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
        } catch (Exception $ex) {
            echo $ex->getMessage();exit;
        }
        }
        
        
        
    
}

