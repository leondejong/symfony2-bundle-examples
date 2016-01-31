<?php

namespace Example\ApplicationBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Example\ApplicationBundle\Form\EventListener\FormSubscriber;

class BaseType extends AbstractType
{
    protected $subscriber;
    
    public function __construct(FormSubscriber $subscriber = null)
    {
        $this->subscriber = $subscriber;
    }
    
    public function setSubscriber(FormSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
    
    public function addSubscriber(FormBuilderInterface $builder)
    {
        if($this->subscriber)
            $builder->addEventSubscriber($this->subscriber);
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addSubscriber($builder);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Example\ApplicationBundle\Entity\Base',
            'intention'  => 'base',
        ));
    }

    public function getName()
    {
        return 'example_applicationbundle_basetype';
    }
}
