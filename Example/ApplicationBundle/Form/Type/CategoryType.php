<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends BaseType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', 'entity', array(
                'class' => 'ExampleApplicationBundle:User',
                'property' => 'username',
                'label' => 'User',
            ))
            ->add('title', 'text', array('label' => 'Title'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('tags', 'textarea', array('label' => 'Tags'));
        
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\Category',
            'intention'  => 'category',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_categorytype';
    }
}
