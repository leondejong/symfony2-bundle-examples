<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ObjectType extends BaseType
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
            ->add('page', 'entity', array(
                'class' => 'ExampleApplicationBundle:Page',
                'property' => 'title',
                'label' => 'Page',
            ))
            ->add('item', 'entity', array(
                'class' => 'ExampleApplicationBundle:Item',
                'property' => 'title',
                'label' => 'Item',
            ))
            ->add('title', 'text', array('label' => 'Title'))
            ->add('description', 'textarea', array('label' => 'Description'))
            ->add('file', 'file', array('label' => 'File', 'data_class' => null))
            ->add('tags', 'textarea', array('label' => 'Tags'));
        
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\Object',
            'intention'  => 'object',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_objecttype';
    }
}
