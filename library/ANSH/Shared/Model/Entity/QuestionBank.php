<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionBank
 *
 * @ORM\Table(name="question_bank")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_QuestionBank
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
     * @ORM\Column(name="question", type="text", nullable=true)
     */
    private $question;

    /**
     * @var string
     *
     * @ORM\Column(name="options", type="text", nullable=true)
     */
    private $options;

    /**
     * @var string
     *
     * @ORM\Column(name="answers", type="text", nullable=false)
     */
    private $answers;

    /**
     * @var float
     *
     * @ORM\Column(name="marks", type="float", nullable=true)
     */
    private $marks;

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
     * @var boolean
     *
     * @ORM\Column(name="deleted", type="boolean", nullable=true)
     */
    private $deleted;
    
    /**
     * @var ANSH_Shared_Model_Entity_QuestionCategories
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_QuestionCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var ANSH_Shared_Model_Entity_QuestionTypes
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_QuestionTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="question_type_id", referencedColumnName="id")
     * })
     */
    private $questionType;

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
     * Set question
     *
     * @param string $question
     * @return QuestionBank
     */
    public function setQuestion($question)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return string 
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set options
     *
     * @param string $options
     * @return QuestionBank
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Get options
     *
     * @return string 
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Set answers
     *
     * @param string $answers
     * @return QuestionBank
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
     * Set marks
     *
     * @param float $marks
     * @return QuestionBank
     */
    public function setMarks($marks)
    {
        $this->marks = $marks;

        return $this;
    }

    /**
     * Get marks
     *
     * @return float 
     */
    public function getMarks()
    {
        return $this->marks;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return QuestionBank
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
     * @return QuestionBank
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
     * Set deleted
     *
     * @param boolean $deleted
     * @return QuestionBank
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
    /**
     * Set category
     *
     * @param ANSH_Shared_Model_Entity_QuestionCategories $category
     * @return QuestionBank
     */
    public function setCategory(ANSH_Shared_Model_Entity_QuestionCategories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return ANSH_Shared_Model_Entity_QuestionTypes 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set questionType
     *
     * @param ANSH_Shared_Model_Entity_QuestionTypes $questionType
     * @return QuestionBank
     */
    public function setQuestionType(ANSH_Shared_Model_Entity_QuestionTypes $questionType = null)
    {
        $this->questionType = $questionType;

        return $this;
    }

    /**
     * Get ANSH_Shared_Model_Entity_QuestionTypes
     *
     * @return ANSH_Shared_Model_Entity_QuestionTypes 
     */
    public function getQuestionType()
    {
        return $this->questionType;
    }

}
