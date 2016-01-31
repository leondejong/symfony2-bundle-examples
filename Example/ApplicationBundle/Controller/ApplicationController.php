<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * Default controller.
 *
 * @Route("/application")
 */
class ApplicationController extends BaseController
{
    /**
    * @Route("/", name="application_index")
    * @Method({"GET"})
    * @Template()
    */
    public function indexAction()
    {
        return array(
            'controller'    => 'application',
            'action'        => 'index',
            'value'         => 'none'
        );
    }
}