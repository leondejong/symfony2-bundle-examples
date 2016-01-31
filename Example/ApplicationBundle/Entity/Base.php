<?php

namespace Example\ApplicationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Example\ApplicationBundle\Entity\Base
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 */
class Base
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="`id`", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $id = null;
    
    /**
     * @var string $name
     * @ORM\Column(name="`name`", type="string", length=255, unique=true, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(64)
     */
    protected $name = null;
    
    /**
     * @var integer $type
     * @ORM\Column(name="`type`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $type = 1;

    /**
     * @var integer $status
     * @ORM\Column(name="`status`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $status = 1;
    
    /**
     * @var integer $position
     * @ORM\Column(name="`position`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $position = 1;

    /**
     * @var string $data
     * @ORM\Column(name="`data`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $data = null;

    /**
     * @var \DateTime $date
     * @ORM\Column(name="`date`", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $date = null;

    /**
     * @var \DateTime $change
     * @ORM\Column(name="`change`", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $change = null;
    
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
     * Set name
     *
     * @param string $name
     * @return Base
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set type
     *
     * @param integer $type
     * @return Base
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Set status
     *
     * @param integer $status
     * @return Base
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * Set position
     *
     * @param integer $position
     * @return Base
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set data
     *
     * @param string $data
     * @return Base
     */
    public function setData($data)
    {
        $this->data = $data;
    
        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Base
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setDateValue()
    {
        $this->date = new \DateTime();
    }

    /**
     * Set change
     *
     * @param \DateTime $change
     * @return Base
     */
    public function setChange($change)
    {
        $this->change = $change;
    
        return $this;
    }

    /**
     * Get change
     *
     * @return \DateTime 
     */
    public function getChange()
    {
        return $this->change;
    }
    
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setChangeValue()
    {
        $this->change = new \DateTime();
    }
}