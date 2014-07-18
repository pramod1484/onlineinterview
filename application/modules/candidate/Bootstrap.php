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
class Candidate_Bootstrap extends Zend_Application_Module_Bootstrap
{

    public function _initResources ()
    {
        $loader = new Zend_Loader_PluginLoader();
        // $loader->addPrefixPath('Zend_View_Helper', 'Zend/View/Helper/')
        $loader->addPrefixPath('Candidate_Custom_Plugin', 
                'application/modules/candidate/custom/plugin')->addPrefixPath(
                'Candidate_Form', 'application/modules/candidate/forms');
    }
}
