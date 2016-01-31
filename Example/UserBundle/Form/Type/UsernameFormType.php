<?php

namespace Example\UserBundle\Form\Type;

use Example\UserBundle\Form\DataTransformer\UserToUsernameTransformer;
use Symfony\Component\Form\FormBuilderInterface;

use FOS\UserBundle\Form\Type\UsernameFormType as BaseUsernameFormType;

class UsernameFormType extends BaseUsernameFormType
{
    /**
     * @var UserToUsernameTransformer
     */
    protected $usernameTransformer;

    /**
     * Constructor.
     *
     * @param UserToUsernameTransformer $usernameTransformer
     */
    public function __construct(UserToUsernameTransformer $usernameTransformer)
    {
        $this->usernameTransformer = $usernameTransformer;
    }

    /**
     * @see Symfony\Component\Form\AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->usernameTransformer);
    }

    /**
     * @see Symfony\Component\Form\AbstractType::getParent()
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * @see Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'example_user_username';
    }
}
