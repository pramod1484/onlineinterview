<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * TestCategories
 *
 * @ORM\Table(name="test_categories")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_TestCategories
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
     * @var \QuestionCategories
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_QuestionCategories")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * })
     */
    private $category;

    /**
     * @var \Tests
     *
     * @ORM\ManyToOne(targetEntity="ANSH_Shared_Model_Entity_Tests")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     * })
     */
    private $test;

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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return TestCategories
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
     * @return TestCategories
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
     * Set category
     *
     * @param \ANSH_Shared_Model_Entity_QuestionCategories $category
     * @return TestCategories
     */
    public function setCategory(\ANSH_Shared_Model_Entity_QuestionCategories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \ANSH_Shared_Model_Entity_QuestionCategories 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set test
     *
     * @param \ANSH_Shared_Model_Entity_Tests $test
     * @return TestCategories
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

}
