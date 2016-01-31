<?php

namespace Example\ApplicationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Example\ApplicationBundle\Entity\ObjectRepository;
use Example\ApplicationBundle\Entity\User;
use Example\ApplicationBundle\Entity\Category;
use Example\ApplicationBundle\Entity\Page;
use Example\ApplicationBundle\Entity\Item;
use Example\ApplicationBundle\Entity\Message;

/**
 * Example\ApplicationBundle\Entity\Object
 *
 * @ORM\Table(name="`object`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="ObjectRepository")
 */
class Object extends Base
{
    const IMAGE     = 1;
    const DOCUMENT  = 2;
    const VIDEO     = 3;
    
    const UPLOAD        = 'object/upload';
    const CONTENT       = 'object/content';
    const PREVIEW       = 'object/preview';
    const THUMBNAIL     = 'object/thumbnail';
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="objects")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="objects")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="objects")
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id")
     */
    protected $page = null;
    
    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="objects")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    protected $item = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="object", cascade="all")
     */
    protected $messages = null;
    
    /**
     * @var string $title
     * @ORM\Column(name="`title`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(4)
     * @Assert\MaxLength(64)
     */
    protected $title = null;
    
    /**
     * @var string $description
     * @ORM\Column(name="`description`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $description = null;
    
     /**
     * @var string $file
     * @ORM\Column(name="`file`", type="text", nullable=true)
     * @Assert\File(
     *     maxSize = "8M",
     *     mimeTypes = {"image/png", "image/jpeg", "application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PNG, JPG or PDF file."
     * )
     */
    protected $file = null;
    
    /**
     * @var string $reference
     * @ORM\Column(name="`reference`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $reference = null;
    
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
     * @var string $previous
     */
    protected $previous = null;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }
    
    /**
     * Set title
     *
     * @param string $title
     * @return Object
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
     * @return Object
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
     * Set file
     *
     * @param string $file
     * @return Object
     */
    public function setFile($file)
    {
        $this->file = $file;
    
        return $this;
    }

    /**
     * Get file
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
    
    /**
     * Set reference
     *
     * @param string $reference
     * @return Object
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    
        return $this;
    }

    /**
     * Get reference
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }
    
    /**
     * Set tags
     *
     * @param string $tags
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * Add messages
     *
     * @param Message $messages
     * @return Object
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
     * Get get absolute upload directory
     *
     * @return String
     */
    protected function getAbsoluteUploadDirectory()
    {
        return __DIR__.'/../../../../web/'.$this->getRelativeUploadDirectory();
    }

    /**
     * Get get relative upload directory
     *
     * @return String
     */
    protected function getRelativeUploadDirectory()
    {
        return self::UPLOAD;
    }
    
    /**
     * Get absolute reference
     *
     * @return String
     */
    public function getAbsoluteReference()
    {
        return null === $this->reference ? null : $this->getAbsoluteUploadDirectory().'/'.$this->reference;
    }
    
    /**
     * Get relative reference
     *
     * @return String
     */
    public function getRelativeReference()
    {
        return null === $this->reference ? null : $this->getRelativeUploadDirectory().'/'.$this->reference;
    }
    
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if(null !== $this->file)
        {
            $name = sha1(uniqid(mt_rand(), true));
            $this->previous = $this->getAbsoluteReference();
            $this->reference = $name.'.'.$this->file->guessExtension();
            $this->setData($this->file->getClientMimeType());
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if(null === $this->file)
            return;
        
        $this->file->move($this->getAbsoluteUploadDirectory(), $this->reference);
        
        if(file_exists($this->previous))
            unlink($this->previous);
        
        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if($file = $this->getAbsoluteReference())
            unlink($file);
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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
     * @return Object
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