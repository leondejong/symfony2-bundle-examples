<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends BaseController
{
    /**
    * @Route("/", name="index")
    * @Method({"GET"})
    * @Template()
    */
    public function indexAction()
    {
        return array(
            'controller'    => 'default',
            'action'        => 'index',
            'value'         => 'none'
        );
    }
    
    /**
    * @Route("/home", name="home")
    * @Route("/home/")
    * @Method({"GET"})
    * @Template()
    */
    public function homeAction()
    {
        return array(
            'controller'    => 'default',
            'action'        => 'home',
            'value'         => 'none'
        );
    }
}