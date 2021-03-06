<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PageType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'entity', array(
                'class' => 'ExampleApplicationBundle:User',
                'property' => 'username',
                'label' => 'User',
            ))
            ->add('category', 'entity', array(
                'class' => 'ExampleApplicationBundle:Category',
                'property' => 'title',
                'label' => 'Category',
            ))
            ->add('title', 'text', array('label' => 'Title'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('preface', 'textarea', array('label' => 'Preface'))
            ->add('content', 'textarea', array('label' => 'Content'))
            ->add('tags', 'textarea', array('label' => 'Tags'));
        
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\Page',
            'intention'  => 'page',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_pagetype';
    }
}
