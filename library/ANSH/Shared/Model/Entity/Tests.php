<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Tests
 *
 * @ORM\Table(name="tests")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_Tests
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
     * @ORM\Column(name="test_name", type="string", length=128, nullable=false)
     */
    private $testName;

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
     * Set testName
     *
     * @param string $testName
     * @return Tests
     */
    public function setTestName($testName)
    {
        $this->testName = $testName;

        return $this;
    }

    /**
     * Get testName
     *
     * @return string 
     */
    public function getTestName()
    {
        return $this->testName;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Tests
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
     * @return Tests
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
     * Set technology
     *
     * @param \ANSH_Shared_Model_Entity_Technology $technology
     * @return Tests
     */
    public function setTechnology(\ANSH_Shared_Model_Entity_Technology $technology = null)
    {
        $this->technology = $technology;

        return $this;
    }

    /**
     * Get technology
     *
     * @return \ANSH_Shared_Model_Entity_Technology 
     */
    public function getTechnology()
    {
        return $this->technology;
    }

}
