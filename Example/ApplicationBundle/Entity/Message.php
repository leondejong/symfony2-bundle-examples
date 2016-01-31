<?php

namespace Example\ApplicationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Example\ApplicationBundle\Entity\MessageRepository;
use Example\ApplicationBundle\Entity\User;
use Example\ApplicationBundle\Entity\Category;
use Example\ApplicationBundle\Entity\Page;
use Example\ApplicationBundle\Entity\Item;
use Example\ApplicationBundle\Entity\Object;

/**
 * Example\ApplicationBundle\Entity\Message
 *
 * @ORM\Table(name="`message`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="MessageRepository")
 */
class Message extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="messages")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="messages")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="messages")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    protected $page = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="messages")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    protected $item = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Object", inversedBy="messages")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id")
     */
    protected $object = null;
    
    /**
     * @var string $title
     * @ORM\Column(name="`title`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     * @Assert\MinLength(4)
     * @Assert\MaxLength(64)
     */
    protected $title = null;
    
    /**
     * @var string $content
     * @ORM\Column(name="`content`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $content = null;
    
    /**
     * @var integer $views
     * @ORM\Column(name="`views`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $views = 0;
    
    /**
     * @var integer $marks
     * @ORM\Column(name="`marks`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $marks = 0;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return Message
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
    
    /**
     * Set views
     *
     * @param integer $views
     * @return Message
     */
    public function setViews($views)
    {
        $this->views = $views;
    
        return $this;
    }

    /**
     * Get views
     *
     * @return integer 
     */
    public function getViews()
    {
        return $this->views;
    }
    
    /**
     * Set marks
     *
     * @param integer $marks
     * @return Message
     */
    public function setMarks($marks)
    {
        $this->marks = $marks;
    
        return $this;
    }

    /**
     * Get marks
     *
     * @return integer 
     */
    public function getMarks()
    {
        return $this->marks;
    }
    
    /**
     * Set user
     *
     * @param User $user
     * @return Message
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * Set category
     *
     * @param Category $category
     * @return Message
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set page
     *
     * @param Page $page
     * @return Message
     */
    public function setPage(Page $page = null)
    {
        $this->page = $page;
    
        return $this;
    }

    /**
     * Get page
     *
     * @return Page 
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * Set item
     *
     * @param Item $item
     * @return Message
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;
    
        return $this;
    }

    /**
     * Get item
     *
     * @return Item 
     */
    public function getItem()
    {
        return $this->item;
    }
    
    /**
     * Set object
     *
     * @param Object $object
     * @return Message
     */
    public function setObject(Object $object = null)
    {
        $this->object = $object;
    
        return $this;
    }

    /**
     * Get object
     *
     * @return Object 
     */
    public function getObject()
    {
        return $this->object;
    }
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $type;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var integer
     */
    private $position;

    /**
     * @var string
     */
    private $data;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \DateTime
     */
    private $change;


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
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * @return Message
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
     * Set change
     *
     * @param \DateTime $change
     * @return Message
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
}