<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryOptions
 *
 * @author pramodkadam
 */
class ANSH_Resources_Helpers_CommonDropdownOptions extends Zend_Controller_Action_Helper_Abstract
{

    /**
     * 
     * @param type boolean
     * @return type mixed array
     */
    public static function getCategoriesOptions($selectMessage = TRUE)
    {
        //initialize category mapper
        $categoriesMappers = new Admin_Model_QuestionCategoryMapper();
        
        //get allcategories enabled
        $categories = $categoriesMappers->getAllCategories(NULL, true);
        
        
        //return single element array if no categories added
        if ($categories == null)
            return $categoryOptions = array('' => 'No category added.');
        
        
        //change msg of first element
        if ($selectMessage == TRUE)
            $categoryOptions = array('' => 'Select Category');
        
        //create arrau for dropdown
        foreach ($categories as $category) {
            $categoryOptions[$category->getId()] = $category->getCategoryName();
        }
        return $categoryOptions;
    }

    /**
     * 
     * @param type boolean
     * @return type array
     */
    public static function getQuestionTypes($selectMessage = TRUE)
    {
        //initialize question type mapper
        $questiontypeMapper = new Admin_Model_QuestionTypeMapper();
        //get all question types        
        $types = $questiontypeMapper->getAllQuestionTypes();
        $typeOptions = array('' => 'Select Question Type');
        
        //create array for dropdown
        foreach ($types as $type) {
            $typeOptions[$type->getId()] = $type->getQuestionType();
        }
        return $typeOptions;
    }

    /**
     * 
     * @return type mixed array
     */
    public static function getTechnologies()
    {
        //initialize technology mapper
        $technologyMapper = new Admin_Model_TechnologyMapper();
        
        // get all technologies
        $technologies = $technologyMapper->getAllTechnologyData();
        $typeOptions = array('' => 'Select Technology');
        foreach ($technologies as $technology) {
            $typeOptions[$technology->getId()] = $technology->getTechnologyName();
        }
        return $typeOptions;
    }
    
    /**
     * 
     * @param type String
     * @return type mixed array
     */
    public static function getJobPositions($text = "Select position")
    {
        //initialize job position mapper
        $jobPositionMapper = new Admin_Model_JobPositions();
        
        //get all job positions
        $jobPositions = $jobPositionMapper->getAllJobPositionData();
        
        $typeOptions = array('' => $text);
        foreach ($jobPositions as $jobPosition) {
            $typeOptions[$jobPosition->getId()] = $jobPosition->getPosition();
        }
        return $typeOptions;
    }
    /**
     * generate dropdown for test
     * @return type mixed array
     */
    public static function getTests()
    {
        //initialize test mapper
        $testMapper = new Admin_Model_TestMapper();
        
        //get all tests
        $tests = $testMapper->getAllTests(NULL);
        $typeOptions = array('' => 'Assign Test');
        foreach ($tests as $test) {
            $typeOptions[$test->getId()] = $test->getTestName();
        }
        return $typeOptions;
    }

}
