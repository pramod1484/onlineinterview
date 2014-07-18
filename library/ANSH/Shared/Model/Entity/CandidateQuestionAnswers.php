<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * CandidateQuestionAnswers
 *
 * @ORM\Table(name="candidate_question_answers")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_CandidateQuestionAnswers
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
     * @var string
     *
     * @ORM\Column(name="answers", type="text", nullable=true)
     */
    private $answers;

    /**
     * @var float
     *
     * @ORM\Column(name="marks_scored", type="float", nullable=true)
     */
    private $marksScored;

    /**
     * @var string
     *
     * @ORM\Column(name="time_taken", type="string", length=128, nullable=true)
     */
    private $timeTaken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=true)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="remark", type="integer", nullable=true)
     */
    private $remark;

    /**
     * @var \QuestionBank
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_QuestionBank")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_bank_id", referencedColumnName="id")
     * })
     */
    private $questionBank;

    /**
     * @var \CandidateTests
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_CandidateTests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="candidate_test_id", referencedColumnName="id")
     * })
     */
    private $candidateTest;

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
     * Set answers
     *
     * @param string $answers
     * @return CandidateQuestionAnswers
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }

    /**
     * Get answers
     *
     * @return string 
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set marksScored
     *
     * @param float $marksScored
     * @return CandidateQuestionAnswers
     */
    public function setMarksScored($marksScored)
    {
        $this->marksScored = $marksScored;

        return $this;
    }

    /**
     * Get marksScored
     *
     * @return float 
     */
    public function getMarksScored()
    {
        return $this->marksScored;
    }

    /**
     * Set timeTaken
     *
     * @param \string $timeTaken
     * @return CandidateQuestionAnswers
     */
    public function setTimeTaken($timeTaken)
    {
        $this->timeTaken = $timeTaken;

        return $this;
    }

    /**
     * Get timeTaken
     *
     * @return \string 
     */
    public function getTimeTaken()
    {
        return $this->timeTaken;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return CandidateQuestionAnswers
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
     * @return CandidateQuestionAnswers
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
     * Set marksScored
     *
     * @param integer $marksScored
     * @return CandidateQuestionAnswers
     */
    public function setRemark($remarks)
    {
        $this->remark = $remarks;

        return $this;
    }

    /**
     * Get marksScored
     *
     * @return integer 
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * Set questionBank
     *
     * @param ANSH_Shared_Model_Entity_QuestionBank $questionBank
     * @return CandidateQuestionAnswers
     */
    public function setQuestionBank(ANSH_Shared_Model_Entity_QuestionBank $questionBank = null)
    {
        $this->questionBank = $questionBank;

        return $this;
    }

    /**
     * Get questionBank
     *
     * @return ANSH_Shared_Model_Entity_QuestionBank
     */
    public function getQuestionBank()
    {
        return $this->questionBank;
    }

    /**
     * Set candidateTest
     *
     * @param \ANSH_Shared_Model_Entity_CandidateTests $candidateTest
     * @return CandidateQuestionAnswers
     */
    public function setCandidateTest(\ANSH_Shared_Model_Entity_CandidateTests $candidateTest = null)
    {
        $this->candidateTest = $candidateTest;

        return $this;
    }

    /**
     * Get candidateTest
     *
     * @return \ANSH_Shared_Model_Entity_CandidateTests 
     */
    public function getCandidateTest()
    {
        return $this->candidateTest;
    }

}
