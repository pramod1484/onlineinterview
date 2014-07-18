<?php

class Candidate_Form_Profile extends Zend_Form
{

    public $degree;

    public $noticePeriod;

    public $experienceYears;
    
    public $experienceMonths;

    public $city;

    public $locality;

    public $mobileNo;

    public $partialCandidateForm;

    protected $_candidateData;

    protected $_elementDecorators = array(
            array(
                    'ViewHelper'
            ),
            array(
                    'Label'
            ),
            array(
                    'Errors',
                    array(
                            'class' => 'error help-block'
                    )
            )
    );

    protected $_buttonDecorators = array(
            array(
                    'ViewHelper'
            )
    );

    public function __construct ($categoryData = NULL)
    {
        if ($categoryData != null)
            $this->_candidateData = $categoryData;
        parent::__construct();
    }

    public function init ()
    {
        $this->setAction('')
            ->setMethod('post')
            ->setAttrib('class', 'form-horizontal');
        $this->partialCandidateForm = new Admin_Form_Cadidate(
                $this->_candidateData);
        
        $elements[] = $this->partialCandidateForm->getElement('fullName');
        
        $elements[] = $this->partialCandidateForm->getElement('email')
            ->setAttribs(array(
                'readonly' => TRUE
        ))
            ->removeValidator('ANSH_Resources_Validators_NoDbRecordExist')
            ->setRequired(FALSE);
        
        $elements[] = $this->partialCandidateForm->getElement('birthDate');
        
        $elements[] = $this->degree = clone $this->partialCandidateForm->getElement(
                'fullName');
        $this->degree->setName('degree')
            ->setLabel('Highest Degree* :')
            ->setAttrib('placeholder', 'Enter Highest Degree');
        
        $elements[] = $this->experienceYears = clone $this->partialCandidateForm->getElement(
                'position');
        $this->experienceYears->setName('experienceYears')
            ->setLabel('Years')
                ->setDecorators($this->partialCandidateForm->userPartialForm->_elementDecorators)
                ->setMultiOptions($this->setMutiOption(0,25));
         $elements[] = $this->experienceMonths= clone $this->experienceYears;
        $this->experienceMonths->setName('experienceMonths')
            ->setLabel('Months')
                ->setMultiOptions($this->setMutiOption(0,12));
        
        $elements[] = $this->noticePeriod = clone $this->partialCandidateForm->getElement(
                'fullName');
        $this->noticePeriod->setName('noticePeriod')
                ->addValidator('Digits')
            ->setLabel('Notice Period* :')
            ->setAttrib('placeholder', 'Enter notice period in days');
        
        $elements[] = $this->city = clone $this->partialCandidateForm->getElement(
                'fullName');
        $this->city->setLabel('City* :')
            ->setName('city')
            ->setRequired(TRUE);
        
        $elements[] = $this->locality = clone $this->partialCandidateForm->getElement(
                'fullName');
        $this->locality->setName('locality')
                ->setDecorators($this->partialCandidateForm->userPartialForm->_elementDecorators)
            ->setLabel('Address :')
            ->setAttribs(array(
                'placeholder' => 'Enter address'
        ))
            ->setRequired(FALSE);
        
        $elements[] = $this->mobileNo = clone $this->partialCandidateForm->getElement(
                'fullName');
        $this->mobileNo->setName('mobileNo')
            ->setLabel('Mobile No* :')
            ->setAttrib('placeholder', 'Enter your mobile no')
                 ->setRequired(TRUE)
            ->addValidators(
                array(
                        array(
                                new Zend_Validate_Digits(),
                                true
                        ),
                        new Zend_Validate_StringLength(
                                array(
                                        'min' => 10,
                                        'max' => 15
                                ))
                ));
        
        $elements[] = $this->partialCandidateForm->getElement('Save');
        $elements[] = $this->partialCandidateForm->getElement('Reset');
        $elements[] = $this->partialCandidateForm->getElement('Cancel');
        if ($this->_candidateData) {
            
            $this->setFieldValues();
        }
        $this->addElements($elements);
    }
    
    private function setMutiOption($startVal = 0 , $enfVal)
    {
        for( ; $startVal <= $enfVal ; $startVal++)
        {
            $array[$startVal] = $startVal;
        }
        return $array;
    }

    private function setFieldValues ()
    {
        $experianceArray = explode(".", $this->_candidateData->getExperience());
        $this->degree->setValue($this->_candidateData->getDegree());
        $this->experienceYears->setValue($experianceArray[0]);
        $this->experienceMonths->setValue(isset($experianceArray[1])?$experianceArray[1]:'');
        $this->noticePeriod->setValue($this->_candidateData->getNoticePeriod());
        $this->city->setValue($this->_candidateData->getCity());
        $this->locality->setValue($this->_candidateData->getLocality());
        $this->mobileNo->setValue($this->_candidateData->getMobileNo());
    }
}
