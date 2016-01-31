<?php

namespace Example\ApplicationBundle\Form\EventListener;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Example\ApplicationBundle\Entity\User;
use Example\ApplicationBundle\Form\Type\ProfileType;;

class FormSubscriber implements EventSubscriberInterface
{
    private $factory;
    private $container;
    
    public function __construct(FormFactoryInterface $factory, ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->container = $container;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::POST_SET_DATA => 'postSetData'
        );
    }

    public function preSetData(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
        
        if (null === $data)
        {
            return;
        }
        
        $securityContext = $this->container->get('security.context');
        
        $list = explode('\\', get_class($data));
        $name = end($list);
        
        switch($name)
        {
            case 'User':
            {
                if(true === $securityContext->isGranted('ROLE_SUPER'))
                {
                    $form->add($this->factory->createNamed('groups', 'entity', null, array(
                        'class' => 'ExampleApplicationBundle:Group',
                        'property' => 'name',
                        'multiple' => true,
                        'expanded' => true,
                        'label' => 'Group'
                    )));
                }
                
                if(true === $securityContext->isGranted('ROLE_ADMIN'))
                {
                    
                }
                
                if(true === $securityContext->isGranted('ROLE_USER'))
                {
                    $form->add($this->factory->createNamed('profile', new ProfileType()), null, array());
                }
                
                break;
            }
            default:
            {

            }
        }
        
        if ($data->getId())
        {
            
        }
        else
        {
            
        }
    }
    
    public function postSetData(FormEvent $event)
    {
        
    }
}