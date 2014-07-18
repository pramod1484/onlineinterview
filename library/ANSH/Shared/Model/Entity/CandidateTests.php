<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * CandidateTests
 *
 * @ORM\Table(name="candidate_tests")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_CandidateTests
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
     * @var integer
     *
     * @ORM\Column(name="remark", type="integer", nullable=true)
     */
    private $remark;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="datetime", nullable=true)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @var float
     *
     * @ORM\Column(name="total_marks", type="float", nullable=true)
     */
    private $totalMarks;

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
     * @var \ANSH_Shared_Model_Entity_Candidates
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_Candidates")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="candidate_id", referencedColumnName="id")
     * })
     */
    private $candidate;

    /**
     * @var \ANSH_Shared_Model_Entity_Tests
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_Tests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * })
     */
    private $test;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="checked_by", referencedColumnName="id")
     * })
     */
    private $checkedBy;

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
     * Set remark
     *
     * @param integer $remark
     * @return CandidateTests
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;

        return $this;
    }

    /**
     * Get remark
     *
     * @return integer 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     * @return CandidateTests
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime 
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     * @return CandidateTests
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime 
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set totalMarks
     *
     * @param float $totalMarks
     * @return CandidateTests
     */
    public function setTotalMarks($totalMarks)
    {
        $this->totalMarks = $totalMarks;

        return $this;
    }

    /**
     * Get totalMarks
     *
     * @return float 
     */
    public function getTotalMarks()
    {
        return $this->totalMarks;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return CandidateTests
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
     * @return CandidateTests
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
     * Set candidate
     *
     * @param \ANSH_Shared_Model_Entity_Candidates $candidate
     * @return CandidateTests
     */
    public function setCandidate(\ANSH_Shared_Model_Entity_Candidates $candidate = null)
    {
        $this->candidate = $candidate;

        return $this;
    }

    /**
     * Get candidate
     *
     * @return \ANSH_Shared_Model_Entity_Candidates 
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * Set test
     *
     * @param \ANSH_Shared_Model_Entity_Tests $test
     * @return CandidateTests
     */
    public function setTest(\ANSH_Shared_Model_Entity_Tests $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \Tests 
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set checkedBy
     *
     * @param \ANSH_Shared_Model_Entity_Users $checkedBy
     * @return CandidateTests
     */
    public function setCheckedBy(\ANSH_Shared_Model_Entity_Users $checkedBy = null)
    {
        $this->checkedBy = $checkedBy;

        return $this;
    }

    /**
     * Get checkedBy
     *
     * @return \ANSH_Shared_Model_Entity_Users 
     */
    public function getCheckedBy()
    {
        return $this->checkedBy;
    }

}
