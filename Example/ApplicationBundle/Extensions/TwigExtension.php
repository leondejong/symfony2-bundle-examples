<?php

namespace Example\ApplicationBundle\Extensions;

use Symfony\Component\DependencyInjection\ContainerInterface;

class TwigExtension extends \Twig_Extension
{
    protected $environment;
    protected $request;
    protected $route;
    protected $controller;
    protected $action;
    
    public function __construct(ContainerInterface $container)
    {
        $this->request = $container->get('request');
    }
    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }
    public function getFunctions()
    {
        return array(
            'controller' => new \Twig_Function_Method($this, 'getController'),
            'action' => new \Twig_Function_Method($this, 'getAction')
        );
    }
    public function getRoute()
    {
        if(empty($this->route))
        {
            $_controller = $this->request->get('_controller');
            $components = explode('\\', $_controller);
            $this->route = explode('::', end($components));
        }
        return $this->route;
    }
    public function getController()
    {
        if(empty($this->controller))
        {
            $route = $this->getRoute();
            $this->controller = strtolower(preg_replace('/Controller$/', '', reset($route)));
        }
        return $this->controller;
    }
    public function getAction()
    {
        if(empty($this->action))
        {
            $route = $this->getRoute();
            $this->action = strtolower(preg_replace('/Action$/', '', end($route)));
        }
        return $this->action;
    }
    public function getName()
    {
        return 'example_application_twig_extension';
    }
}