<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * QuestionCategories
 *
 * @ORM\Table(name="question_categories")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_QuestionCategories
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
     * @ORM\Column(name="category_name", type="string", length=128, nullable=false)
     */
    private $categoryName;

    /**
     * @var string
     *
     * @ORM\Column(name="category_image", type="string", length=255, nullable=true)
     */
    private $categoryImage;

    /**
     * @var integer
     *
     * @ORM\Column(name="time_to_finish", type="integer", nullable=false)
     */
    private $timeToFinish;

    /**
     * @var float
     *
     * @ORM\Column(name="total_marks", type="float", nullable=true)
     */
    private $totalMarks;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_enabled", type="boolean", nullable=false)
     */
    private $isEnabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime", nullable=false)
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=true)
     */
    private $modifiedDate;

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
     * Set categoryName
     *
     * @param string $categoryName
     * @return QuestionCategories
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string 
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * Set categoryImage
     *
     * @param string $categoryImage
     * @return QuestionCategories
     */
    public function setCategoryImage($categoryImage)
    {
        $this->categoryImage = $categoryImage;

        return $this;
    }

    /**
     * Get categoryName
     *
     * @return string 
     */
    public function getCategoryImage()
    {
        return $this->categoryImage;
    }

    /**
     * Set timeToFinish
     *
     * @param integer $timeToFinish
     * @return QuestionCategories
     */
    public function setTimeToFinish($timeToFinish)
    {
        $this->timeToFinish = $timeToFinish;

        return $this;
    }

    /**
     * Get timeToFinish
     *
     * @return integer 
     */
    public function getTimeToFinish()
    {
        return $this->timeToFinish;
    }

    /**
     * Set totalMarks
     *
     * @param float $totalMarks
     * @return QuestionCategories
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
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return QuestionCategories
     */
    public function setIsEnabled($isEnabled)
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    /**
     * Get isEnabled
     *
     * @return boolean 
     */
    public function getIsEnabled()
    {
        return $this->isEnabled;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return QuestionCategories
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
     * @return QuestionCategories
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

}
