<?php

/**
 * Test Controller for admin module add,edit ,view various tests
 */
class Admin_TestController extends Zend_Controller_Action
{

    protected $_testMapper;

    protected $flashMessagner;

    /**
     * initialize testMapper,flashMessanger helper to use in entire class
     */
    public function init ()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        $this->flashMessenger = Zend_Controller_Action_HelperBroker::getStaticHelper(
                'FlashMessenger');
        $this->_testMapper = new Admin_Model_TestMapper();
    }

    public function indexAction ()
    {
        // action body
    }
    
    // list out all tests defined
    public function listAction ()
    {
        $this->view->tests = $this->_testMapper->getAllTests(
                $this->getParam('page'), array(
                        'flag' => TRUE
                ));
    }
    
    // add a new test according to technology and assign multiple categories to
    // test
    public function addAction ()
    {
        try {
            $this->view->form = $form = new Admin_Form_TestCreateForm();
            
            $_request = $this->getRequest();
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                $data = $_request->getPost();
                // check valid data or return to form
                $validTestData = $form->getValidValues($data);
                
                if ($form->isValid($data)) {
                    
                    // checks user inserting or not
                    if ($test = $this->_testMapper->save($validTestData)) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Test ' .
                                                 $test->getTestName() .
                                                 ' added successfully!'
                                ));
                        $this->_redirect('admin/test/list');
                    } else {
                        $this->view->errorMessage = (array(
                                'error' => $this->_testMapper->getErrors()
                        ));
                    }
                }
                $form->populate($validTestData);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    // edit existing test change its technology , categories
    public function editAction ()
    {
        try {
            $_request = $this->getRequest();
            $testId = $_request->getParam('testId');
            $validTestData = $this->_testMapper->getTestById($testId);
            
            if (empty($validTestData)) {
                $this->flashMessenger->addMessage(
                        array(
                                'error' => 'Test not exist!'
                        ));
                $this->_redirect('admin/test/list');
            }
            $this->view->form = $form = new Admin_Form_TestCreateForm(
                    $validTestData);
            
            // check request is strictly post not by other way
            if ($_request->isPost()) {
                
                if ($validTestData->count > 0) {
                    $this->flashMessenger->addMessage(
                            array(
                                    'error' => 'You can\'t edit this test as test already started or finished.'
                            ));
                    $this->_redirect('admin/test/list');
                }
                $data = $_request->getPost();
                // check valid data or return to form
                $validTestData = $form->getValidValues($data);
                $validTestData['id'] = $testId;
                
                if ($form->isValid($data)) {
                    $result = $this->_testMapper->save($validTestData);
                    
                    // checks user inserting or not
                    if ($this->_testMapper->save($validTestData)) {
                        $this->flashMessenger->addMessage(
                                array(
                                        'success' => 'Test ' .
                                                 $result->getTestName() .
                                                 ' updated successfully!'
                                ));
                        $this->_redirect('admin/test/list');
                    } else
                        $this->view->errorMessage = (array(
                                'error' => $this->_testMapper->getErrors()
                        ));
                }
                $form->populate($validTestData);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //delete a test
    public function deleteAction ()
    {
        try {
            $result = $this->_testMapper->deleteTest($this->getParam('testId'));
            if (! $result) {
                $this->flashMessenger->addMessage(
                        $this->_testMapper->getErrors());
            } else {
                $this->flashMessenger->addMessage(
                        array(
                                'success' => $result .
                                         ' Test deleted successfully!'
                        ));
            }
            $this->_redirect('admin/test/list');
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
