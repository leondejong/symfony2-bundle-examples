<?php

namespace Example\ApplicationBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

use Example\ApplicationBundle\Entity\ProfileRepository;
use Example\ApplicationBundle\Entity\User;

/**
 * Example\ApplicationBundle\Entity\Profile
 *
 * @ORM\Table(name="`profile`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="ProfileRepository")
 */
class Profile extends Base
{
    const NONE            = 0;
    const MALE            = 1;
    const FEMALE        = 2;
    const UNSPECIFIED    = 3;
    
    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="profile")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user = null;
    
    /**
     * @var string
     * @ORM\Column(name="`title`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(4)
     * @Assert\MaxLength(64)
     */
    protected $title = null;

    /**
     * @var string
     * @ORM\Column(name="`description`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $description = null;

    /**
     * @var string
     * @ORM\Column(name="`first`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $first = null;

    /**
     * @var string
     * @ORM\Column(name="`last`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $last = null;
    
    /**
     * @var integer
     * @ORM\Column(name="`gender`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=0)
     * @Assert\Max(limit=3)
     */
    protected $gender = 0;

    /**
     * @var \Date
     * @ORM\Column(name="`birth`", type="date", nullable=true)
     * @Assert\Date()
     */
    protected $birth = null;

    /**
     * @var string
     * @ORM\Column(name="`url`", type="text", nullable=true)
     * @Assert\Url()
     */
    protected $url = null;

    /**
     * @var string
     * @ORM\Column(name="`tags`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $tags = null;

    /**
     * @var integer
     * @ORM\Column(name="`views`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $views = 0;

    /**
     * @var integer
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
     * Get genders
     *
     * @return array 
     */
    public static function genders()
    {
        return array(self::UNSPECIFIED => 'unspecified', self::MALE => 'male', self::FEMALE => 'female');
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Profile
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
     * @return Profile
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
     * Set first
     *
     * @param string $first
     * @return Profile
     */
    public function setFirst($first)
    {
        $this->first = $first;
    
        return $this;
    }

    /**
     * Get first
     *
     * @return string 
     */
    public function getFirst()
    {
        return $this->first;
    }

    /**
     * Set last
     *
     * @param string $last
     * @return Profile
     */
    public function setLast($last)
    {
        $this->last = $last;
    
        return $this;
    }

    /**
     * Get last
     *
     * @return string 
     */
    public function getLast()
    {
        return $this->last;
    }
    
    /**
     * Set gender
     *
     * @param integer $gender
     * @return Profile
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return integer 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set birth
     *
     * @param \DateTime $birth
     * @return Profile
     */
    public function setBirth($birth)
    {
        $this->birth = $birth;
    
        return $this;
    }

    /**
     * Get birth
     *
     * @return \DateTime 
     */
    public function getBirth()
    {
        return $this->birth;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Profile
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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