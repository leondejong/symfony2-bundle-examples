<?php

namespace Example\ApplicationBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Example\ApplicationBundle\Entity\UserRepository;
use Example\ApplicationBundle\Entity\Group;
use Example\ApplicationBundle\Entity\Profile;
use Example\ApplicationBundle\Entity\Category;
use Example\ApplicationBundle\Entity\Page;
use Example\ApplicationBundle\Entity\Item;
use Example\ApplicationBundle\Entity\Object;
use Example\ApplicationBundle\Entity\Message;
use Example\ApplicationBundle\Validator\Constraints as CustomAssert;

/**
 * Example\ApplicationBundle\Entity\User
 *
 * @ORM\Table(name="`user`")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="UserRepository")
 * @UniqueEntity(fields="username", message="This user already exists")
 * @UniqueEntity(fields="email", message="This e-mail address is already registered")
 */
class User extends Base implements AdvancedUserInterface, \Serializable
{
    const NONE      = 0;
    const SUPER     = 1;
    const ADMIN     = 2;
    const NORMAL    = 3;
    
    /**
     * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
     * @ORM\JoinTable(name="`user_group`")
     */
    protected $groups = null;
    
    /**
     * @ORM\OneToOne(targetEntity="Profile", mappedBy="user", cascade="all")
     */
    protected $profile = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="user", cascade="all")
     */
    protected $categories = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Page", mappedBy="user", cascade="all")
     */
    protected $pages = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Item", mappedBy="user", cascade="all")
     */
    protected $items = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Object", mappedBy="user", cascade="all")
     */
    protected $objects = null;
    
    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="user", cascade="all")
     */
    protected $messages = null;
    
    /**
     * @var string
     * @ORM\Column(name="`username`", type="string", unique=true, length=255, nullable=false)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     * @Assert\MinLength(3)
     * @Assert\MaxLength(16)
     * @CustomAssert\Alphanumeric
     */
    protected $username = null;

    /**
     * @var string
     * @ORM\Column(name="`password`", type="string", length=255, nullable=false)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\NotBlank()
     * @Assert\MinLength(3)
     * @Assert\MaxLength(255)
     */
    protected $password = null;

    /**
     * @var string
     * @ORM\Column(name="`email`", type="string", unique=true, length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid e-mail address.",
     *     checkMX = true
     * )
     */
    protected $email = null;

    /**
     * @var integer
     * @ORM\Column(name="`level`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $level = self::NONE;

    /**
     * @var integer
     * @ORM\Column(name="`views`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $views = self::NONE;

    /**
     * @var integer
     * @ORM\Column(name="`logins`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $logins = self::NONE;

    /**
     * @var integer
     * @ORM\Column(name="`success`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $success = self::NONE;

    /**
     * @var integer
     * @ORM\Column(name="`failure`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $failure = self::NONE;

    /**
     * @var integer
     * @ORM\Column(name="`marks`", type="integer", nullable=true)
     * @Assert\Type(type="integer", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\Min(limit=-2147483647)
     * @Assert\Max(limit=2147483647)
     */
    protected $marks = self::NONE;

    /**
     * @var string
     * @ORM\Column(name="`key`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $key = null;

    /**
     * @var string
     * @ORM\Column(name="`session`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $session = null;

    /**
     * @var string
     * @ORM\Column(name="`cookie`", type="text", nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(16384)
     */
    protected $cookie = null;

    /**
     * @var string
     * @ORM\Column(name="`ip`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $ip = null;

    /**
     * @var string
     * @ORM\Column(name="`agent`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $agent = null;

    /**
     * @var string
     * @ORM\Column(name="`accept`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $accept = null;

    /**
     * @var string
     * @ORM\Column(name="`charset`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $charset = null;

    /**
     * @var string
     * @ORM\Column(name="`encoding`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $encoding = null;

    /**
     * @var string
     * @ORM\Column(name="`language`", type="string", length=255, nullable=true)
     * @Assert\Type(type="string", message="The value {{ value }} is not a valid {{ type }}.")
     * @Assert\MinLength(0)
     * @Assert\MaxLength(255)
     */
    protected $language = null;

    /**
     * @var \DateTime
     * @ORM\Column(name="`visit`", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    protected $visit = null;
    
    /**
     * @var string
     */
    protected $salt = 'quantumweirdness';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }
    
    /**
     * \Serializable::serialize()
     */
    public function serialize()
    {
        return \serialize(array(
            $this->id,
            $this->name,
            $this->type,
            $this->status,
            $this->position,
            $this->data,
            $this->date,
            $this->change,
            $this->username,
            $this->password,
            $this->email,
            $this->level,
            $this->views,
            $this->logins,
            $this->success,
            $this->failure,
            $this->marks,
            $this->key,
            $this->session,
            $this->cookie,
            $this->ip,
            $this->agent,
            $this->accept,
            $this->charset,
            $this->encoding,
            $this->language,
            $this->visit,
            $this->groups,
            $this->profile,
            $this->categories,
            $this->pages,
            $this->items,
            $this->objects,
            $this->messages,
            $this->salt
        ));
    }

    /**
     * \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->name,
            $this->type,
            $this->status,
            $this->position,
            $this->data,
            $this->date,
            $this->change,
            $this->username,
            $this->password,
            $this->email,
            $this->level,
            $this->views,
            $this->logins,
            $this->success,
            $this->failure,
            $this->marks,
            $this->key,
            $this->session,
            $this->cookie,
            $this->ip,
            $this->agent,
            $this->accept,
            $this->charset,
            $this->encoding,
            $this->language,
            $this->visit,
            $this->groups,
            $this->profile,
            $this->categories,
            $this->pages,
            $this->items,
            $this->objects,
            $this->messages,
            $this->salt
        ) = \unserialize($serialized);
    }
    
    /**
     * Get levels
     *
     * @return array 
     */
    public static function levels()
    {
        return array(self::SUPER => 'super', self::ADMIN => 'admin', self::NORMAL => 'normal');
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
    
        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return User
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set views
     *
     * @param integer $views
     * @return User
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
     * Set logins
     *
     * @param integer $logins
     * @return User
     */
    public function setLogins($logins)
    {
        $this->logins = $logins;
    
        return $this;
    }

    /**
     * Get logins
     *
     * @return integer 
     */
    public function getLogins()
    {
        return $this->logins;
    }

    /**
     * Set success
     *
     * @param integer $success
     * @return User
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    
        return $this;
    }

    /**
     * Get success
     *
     * @return integer 
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Set failure
     *
     * @param integer $failure
     * @return User
     */
    public function setFailure($failure)
    {
        $this->failure = $failure;
    
        return $this;
    }

    /**
     * Get failure
     *
     * @return integer 
     */
    public function getFailure()
    {
        return $this->failure;
    }

    /**
     * Set marks
     *
     * @param integer $marks
     * @return User
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
     * Set key
     *
     * @param string $key
     * @return User
     */
    public function setKey($key)
    {
        $this->key = $key;
    
        return $this;
    }

    /**
     * Get key
     *
     * @return string 
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set session
     *
     * @param string $session
     * @return User
     */
    public function setSession($session)
    {
        $this->session = $session;
    
        return $this;
    }

    /**
     * Get session
     *
     * @return string 
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set cookie
     *
     * @param string $cookie
     * @return User
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    
        return $this;
    }

    /**
     * Get cookie
     *
     * @return string 
     */
    public function getCookie()
    {
        return $this->cookie;
    }

    /**
     * Set ip
     *
     * @param string $ip
     * @return User
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    
        return $this;
    }

    /**
     * Get ip
     *
     * @return string 
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set agent
     *
     * @param string $agent
     * @return User
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    
        return $this;
    }

    /**
     * Get agent
     *
     * @return string 
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set accept
     *
     * @param string $accept
     * @return User
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;
    
        return $this;
    }

    /**
     * Get accept
     *
     * @return string 
     */
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * Set charset
     *
     * @param string $charset
     * @return User
     */
    public function setCharset($charset)
    {
        $this->charset = $charset;
    
        return $this;
    }

    /**
     * Get charset
     *
     * @return string 
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Set encoding
     *
     * @param string $encoding
     * @return User
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
    
        return $this;
    }

    /**
     * Get encoding
     *
     * @return string 
     */
    public function getEncoding()
    {
        return $this->encoding;
    }

    /**
     * Set language
     *
     * @param string $language
     * @return User
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    
        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set visit
     *
     * @param \DateTime $visit
     * @return User
     */
    public function setVisit($visit)
    {
        $this->visit = $visit;
    
        return $this;
    }

    /**
     * Get visit
     *
     * @return \DateTime 
     */
    public function getVisit()
    {
        return $this->visit;
    }
    
    /**
     * Add groups
     *
     * @param Group $groups
     * @return User
     */
    public function addGroup(Group $groups)
    {
        $this->groups[] = $groups;
    
        return $this;
    }

    /**
     * Remove groups
     *
     * @param Group $groups
     */
    public function removeGroup(Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Set profile
     *
     * @param Profile $profile
     * @return User
     */
    public function setProfile(Profile $profile = null)
    {
        $this->profile = $profile;
    
        return $this;
    }

    /**
     * Get profile
     *
     * @return Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Add categories
     *
     * @param Category $categories
     * @return User
     */
    public function addCategorie(Category $categories)
    {
        $this->categories[] = $categories;
    
        return $this;
    }

    /**
     * Remove categories
     *
     * @param Category $categories
     */
    public function removeCategorie(Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Add pages
     *
     * @param Page $pages
     * @return User
     */
    public function addPage(Page $pages)
    {
        $this->pages[] = $pages;
    
        return $this;
    }

    /**
     * Remove pages
     *
     * @param Page $pages
     */
    public function removePage(Page $pages)
    {
        $this->pages->removeElement($pages);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Add items
     *
     * @param Item $items
     * @return User
     */
    public function addItem(Item $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param Item $items
     */
    public function removeItem(Item $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add objects
     *
     * @param Object $objects
     * @return User
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
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getObjects()
    {
        return $this->objects;
    }

    /**
     * Add messages
     *
     * @param Message $messages
     * @return User
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
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessages()
    {
        return $this->messages;
    }
    
    /**
     * Get salt
     *
     * @return string 
     */
    public function getSalt()
    {
        return $this->salt;
    }
    
    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        $roles = array();
        foreach ($this->groups as $group) {
            $roles[] = new Role($group->getRole());
        }
        return $roles;
        
        //return $this->groups->toArray();
        
        /*switch($this->level)
        {
            case self::SUPER:
                return array('ROLE_SUPER');
            case self::ADMIN:
                return array('ROLE_ADMIN');
            default:
                return array('ROLE_USER');
        }*/
    }
    
    /**
     * Erase credentials
     *
     * @return null
     */
    public function eraseCredentials()
    {
        return null;
    }
    
    /**
     * Is account non expired
     *
     * @return boolean
     */
    public function isAccountNonExpired()
    {
        return true;
    }
    
    /**
     * Is account non locked
     *
     * @return boolean
     */
    public function isAccountNonLocked()
    {
        return true;
    }
    
    /**
     * Is credentials non expired
     *
     * @return boolean
     */
    public function isCredentialsNonExpired()
    {
        return true;
    }

    /**
     * Is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->getStatus();
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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
     * @return User
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