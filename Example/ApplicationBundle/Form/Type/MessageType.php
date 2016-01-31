<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MessageType extends BaseType
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
            ->add('object', 'entity', array(
                'class' => 'ExampleApplicationBundle:Object',
                'property' => 'title',
                'label' => 'Object',
            ))
            ->add('title', 'text', array('label' => 'Title'))
            ->add('content', 'textarea', array('label' => 'Content'));
        
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\Message',
            'intention'  => 'message',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_messagetype';
    }
}
