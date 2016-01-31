<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Example\ApplicationBundle\Entity\User;

class UserType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Username'))
            ->add('password', 'repeated', array(
                'label' => 'Password',
                'first_name' => 'Password',
                'second_name' => 'Confirm',
                'type' => 'password',))
            ->add('email', 'email', array('label' => 'Email'));
        
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\User',
            'intention'  => 'user',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_usertype';
    }
}
