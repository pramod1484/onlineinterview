<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidates
 *
 * @ORM\Table(name="candidates")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_Candidates
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date", nullable=true)
     */
    private $dateOfBirth;

    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="string", length=128, nullable=true)
     */
    private $degree;

    /**
     * @var string
     *
     * @ORM\Column(name="refered_by", type="string", length=128, nullable=true)
     */
    private $referedBy;

    /**
     * @var string
     *
     * @ORM\Column(name="experience", type="string", length=128, nullable=true)
     */
    private $experience;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile_no", type="string", length=128, nullable=true)
     */
    private $mobileNo;

    /**
     * @var integer
     *
     * @ORM\Column(name="notice_period", type="integer", nullable=true)
     */
    private $noticePeriod;

    /**
     * @var string
     *
     * @ORM\Column(name="locality", type="string", length=128, nullable=true)
     */
    private $locality;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=false)
     */
    private $modifiedDate;

    /**
     * @var ANSH_Shared_Model_Entity_Users
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

   /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=128, nullable=true)
     */
    private $city;

    /**
     * @var \ANSH_Shared_Model_Entity_JobPositions
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_JobPositions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="job_position_id", referencedColumnName="id")
     * })
     */
    private $jobPosition;

    /**
     * @var \ANSH_Shared_Model_Entity_Technology
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_Technology")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="technology_id", referencedColumnName="id")
     * })
     */
    private $technology;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return Candidates
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set degree
     *
     * @param string $degree
     * @return Candidates
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return string 
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set referedBy
     *
     * @param string $referedBy
     * @return Candidates
     */
    public function setReferedBy($referedBy)
    {
        $this->referedBy = $referedBy;

        return $this;
    }

    /**
     * Get referedBy
     *
     * @return string 
     */
    public function getReferedBy()
    {
        return $this->referedBy;
    }

    /**
     * Set experience
     *
     * @param string $experience
     * @return Candidates
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return string 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set mobileNo
     *
     * @param string $mobileNo
     * @return Candidates
     */
    public function setMobileNo($mobileNo)
    {
        $this->mobileNo = $mobileNo;

        return $this;
    }

    /**
     * Get mobileNo
     *
     * @return string 
     */
    public function getMobileNo()
    {
        return $this->mobileNo;
    }

    /**
     * Set noticePeriod
     *
     * @param integer $noticePeriod
     * @return Candidates
     */
    public function setNoticePeriod($noticePeriod)
    {
        $this->noticePeriod = $noticePeriod;

        return $this;
    }

    /**
     * Get noticePeriod
     *
     * @return integer 
     */
    public function getNoticePeriod()
    {
        return $this->noticePeriod;
    }

    /**
     * Set locality
     *
     * @param string $locality
     * @return Candidates
     */
    public function setLocality($locality)
    {
        $this->locality = $locality;

        return $this;
    }

    /**
     * Get locality
     *
     * @return string 
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Candidates
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Candidates
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;

        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set user
     *
     * @param \ANSH_Shared_Model_Entity_Users $user
     * @return Candidates
     */
    public function setUser(\ANSH_Shared_Model_Entity_Users $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \ANSH_Shared_Model_Entity_Users 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set city
     *
     * @param String $city
     * @return Candidates
     */
    public function setCity($city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set jobPosition
     *
     * @param \JobPositions $jobPosition
     * @return Candidates
     */
    public function setJobPosition(\ANSH_Shared_Model_Entity_JobPositions $jobPosition = null)
    {
        $this->jobPosition = $jobPosition;

        return $this;
    }

    /**
     * Get jobPosition
     *
     * @return \JobPositions 
     */
    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    /**
     * Set technology
     *
     * @param \Technology $technology
     * @return Candidates
     */
    public function setTechnology(\ANSH_Shared_Model_Entity_Technology $technology = null)
    {
        $this->technology = $technology;

        return $this;
    }

    /**
     * Get technology
     *
     * @return \Technology 
     */
    public function getTechnology()
    {
        return $this->technology;
    }

}
