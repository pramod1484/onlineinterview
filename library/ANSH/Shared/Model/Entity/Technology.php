<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * Technology
 *
 * @ORM\Table(name="technology")
 * @ORM\Entity
 */
class ANSH_Shared_Model_Entity_Technology
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
     * @ORM\Column(name="technology_name", type="string", length=128, nullable=false)
     */
    private $technologyName;

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
     * @ORM\Column(name="modified_date", type="datetime", nullable=false)
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
     * Set technologyName
     *
     * @param string $technologyName
     * @return Technology
     */
    public function setTechnologyName($technologyName)
    {
        $this->technologyName = $technologyName;

        return $this;
    }

    /**
     * Get technologyName
     *
     * @return string 
     */
    public function getTechnologyName()
    {
        return $this->technologyName;
    }

    /**
     * Set isEnabled
     *
     * @param boolean $isEnabled
     * @return Technology
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
     * @return Technology
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
     * @return Technology
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
