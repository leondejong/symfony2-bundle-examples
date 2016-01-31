<?php

namespace Example\ApplicationBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Example\ApplicationBundle\Entity\User;

class Registration extends Base
{
    /**
     * @Assert\Type(type="Example\ApplicationBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $accept;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getAccept()
    {
        return $this->accept;
    }

    public function setAccept($accept)
    {
        $this->accept = (Boolean) $accept;
    }
}