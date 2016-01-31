<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Example\ApplicationBundle\Entity\Profile;

class ProfileType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Title'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('first', 'text', array('label' => 'First'))
            ->add('last', 'text', array('label' => 'Last'))
            ->add('gender', 'choice', array('label' => 'Gender', 'choices' => Profile::genders()))
            ->add('birth', 'birthday', array('label' => 'Birth'))
            ->add('url', 'url', array('label' => 'Url'))
            ->add('tags', 'textarea', array('label' => 'Tags'));

        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\Profile',
            'intention'  => 'profile',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_profiletype';
    }
}
