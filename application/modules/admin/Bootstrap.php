<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates and open the template
 * in the editor.
 */

/**
 * Description of Bootstrap
 *
 * @author pramodkadam
 */
class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{
    
    // TODO ADD SSL in script
    // protected function _initForceSSL() {
    // if($_SERVER['SERVER_PORT'] != '443') {
    // header('Location: https://' . $_SERVER['HTTP_HOST'] .
    // $_SERVER['REQUEST_URI']);
    // exit();
    // }
    // }
    public function _initResources ()
    {
        $view = new Zend_View();
        $view->addHelperPath('ZendX/JQuery/View/Helper/', 
                'ZendX_JQuery_View_Helper');
        
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        
        $loader = new Zend_Loader_PluginLoader();
        $loader->addPrefixPath('Admin_Custom_Plugin', 
                'application/modules/admin/custom/plugin')
            ->addPrefixPath('Admin_Custom_Helpers', 
                'application/modules/admin/custom/helpers')
            ->addPrefixPath('Admin_Form', 'application/modules/admin/forms');
        
        $pages = array(
                array(
                        'label' => 'Dashboard',
                        'title' => 'Dashboard',
                        'route' => 'default',
                        'module' => 'admin',
                        'class' => 'active ajax-link',
                        'controller' => 'index',
                        'action' => 'index',
                        'order' => - 100 // make sure home is the first page
                                ),
                array(
                        'label' => 'Admin Users',
                        'title' => 'Admin Users',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Users',
                                        'title' => 'View Users',
                                        'module' => 'admin',
                                        'controller' => 'user',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add User',
                                        'title' => 'Add User',
                                        'controller' => 'user',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit User',
                                        'title' => 'Edit User',
                                        'class' => 'hide',
                                        'controller' => 'user',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
                array(
                        'label' => 'Question Categories',
                        'title' => 'Question Categories',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Categories',
                                        'title' => 'View Question Categories',
                                        'module' => 'admin',
                                        'controller' => 'question-category',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add Category',
                                        'title' => 'Add Question Category',
                                        'controller' => 'question-category',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit Category',
                                        'title' => 'Edit Question Category',
                                        'class' => 'hide',
                                        'controller' => 'question-category',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
                array(
                        'label' => 'Questions',
                        'title' => 'Questions',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Questions',
                                        'title' => 'View Questions',
                                        'module' => 'admin',
                                        'controller' => 'question',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add Question',
                                        'title' => 'Add Question',
                                        'controller' => 'question',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit Question',
                                        'title' => 'Edit Question',
                                        'class' => 'hide',
                                        'controller' => 'question',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
                array(
                        'label' => 'Test Technology',
                        'title' => 'Test Technology',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Technologies',
                                        'title' => 'View Test Technologies',
                                        'module' => 'admin',
                                        'controller' => 'technology',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add Technology',
                                        'title' => 'Add Technology',
                                        'controller' => 'technology',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit Technology',
                                        'title' => 'Edit Technology',
                                        'class' => 'hide',
                                        'controller' => 'technology',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
                array(
                        'label' => 'Test',
                        'title' => 'Test',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Tests',
                                        'title' => 'View Tests',
                                        'module' => 'admin',
                                        'controller' => 'test',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add Test',
                                        'title' => 'Add Test',
                                        'controller' => 'test',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit Test',
                                        'title' => 'Edit Test',
                                        'class' => 'hide',
                                        'controller' => 'test',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
             array(
                        'label' => 'Job Position',
                        'title' => 'Job Position',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Job Positions',
                                        'title' => 'View Test Job Positions',
                                        'module' => 'admin',
                                        'controller' => 'job-position',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add Job Position',
                                        'title' => 'Add Job Position',
                                        'controller' => 'job-position',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit Job Position',
                                        'title' => 'Edit Job Position',
                                        'class' => 'hide',
                                        'controller' => 'job-position',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
                array(
                        'label' => 'Candidates',
                        'title' => 'Candidates',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Candidates',
                                        'title' => 'View Candidates',
                                        'module' => 'admin',
                                        'controller' => 'candidate',
                                        'action' => 'list'
                                ),
                                array(
                                        'label' => 'Add Candidate',
                                        'title' => 'Add Candidate',
                                        'controller' => 'candidate',
                                        'route' => 'default',
                                        'action' => 'add',
                                        'module' => 'admin'
                                ),
                                array(
                                        'label' => 'Edit Candidate',
                                        'title' => 'Edit Candidate',
                                        'class' => 'hide',
                                        'controller' => 'candidate',
                                        'route' => 'default',
                                        'action' => 'edit',
                                        'module' => 'admin'
                                )
                        )
                ),
             array(
                        'label' => 'Report',
                        'title' => 'Report',
                        'uri' => '#',
                        'class' => 'dropdown-toggle',
                        'pages' => array(
                                array(
                                        'label' => 'View Candidates Report',
                                        'title' => 'View Candidates Report',
                                        'module' => 'admin',
                                        'controller' => 'report',
                                        'action' => 'index'
                                ),
                                array(
                                        'label' => 'View Position wise Report',
                                        'title' => 'Candidate Position wise Report',
                                        'controller' => 'report',
                                        'route' => 'default',
                                        'action' => 'position-wise-report',
                                        'module' => 'admin'
                                ),
                        )
                ),
        );
        
        // Create container from array
        $container = new Zend_Navigation($pages);
        $view->navigation($container);
    }
}
