<?php

namespace Example\ApplicationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Example\ApplicationBundle\Entity\ItemRepository;
use Example\ApplicationBundle\Entity\User;
use Example\ApplicationBundle\Entity\Category;
use Example\ApplicationBundle\Entity\Page;
use Example\ApplicationBundle\Entity\Object;
use Example\ApplicationBundle\Entity\Message;

/**
 * Example\ApplicationBundle\Entity\Item
 *
 * @ORM\Table(name="`item`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="ItemRepository")
 */
class Item extends Base
{
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="items")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="items")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="items")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    protected $page = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Object", mappedBy="item", cascade="all")
     */
    protected $objects = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="item", cascade="all")
     */
    protected $messages = null;
    
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
     * @var string $description
     * @ORM\Column(name="`description`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $description = null;
    
    /**
     * @var string $preface
     * @ORM\Column(name="`preface`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $preface = null;
    
    /**
     * @var string $content
     * @ORM\Column(name="`content`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $content = null;
    
    /**
     * @var string $tags
     * @ORM\Column(name="`tags`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $tags = null;
    
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
        $this->objects = new ArrayCollection();
        $this->messages = new ArrayCollection();
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return Item
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
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set preface
     *
     * @param string $preface
     * @return Item
     */
    public function setPreface($preface)
    {
        $this->preface = $preface;
    
        return $this;
    }

    /**
     * Get preface
     *
     * @return string 
     */
    public function getPreface()
    {
        return $this->preface;
    }
    
    /**
     * Set content
     *
     * @param string $content
     * @return Item
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
     * Set tags
     *
     * @param string $tags
     * @return Item
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }
    
    /**
     * Set views
     *
     * @param integer $views
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * Add objects
     *
     * @param Object $objects
     * @return Item
     */
    public function addObject(Object $objects)
    {
        $this->objects[] = $objects;
    
        return $this;
    }

    /**
     * Remove objects
     *
     * @param Object $objects
     */
    public function removeObject(Object $objects)
    {
        $this->objects->removeElement($objects);
    }

    /**
     * Get objects
     *
     * @return Collection
     */
    public function getObjects()
    {
        return $this->objects;
    }
    
    /**
     * Add messages
     *
     * @param Message $messages
     * @return Item
     */
    public function addMessage(Message $messages)
    {
        $this->messages[] = $messages;
    
        return $this;
    }

    /**
     * Remove messages
     *
     * @param Message $messages
     */
    public function removeMessage(Message $messages)
    {
        $this->messages->removeElement($messages);
    }

    /**
     * Get messages
     *
     * @return Collection
     */
    public function getMessages()
    {
        return $this->messages;
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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