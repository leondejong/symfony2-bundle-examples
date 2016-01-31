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
 * @Route("/security")
 */
class SecurityController extends BaseController
{
    /**
    * @Route("/", name="security_index")
    * @Method({"GET"})
    * @Template()
    */
    public function indexAction()
    {
        return array();
    }
    /**
    * @Route("/login", name="security_login")
    * @Route("/login/")
    * @Method({"GET"})
    * @Template()
    */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR))
        {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        else
        {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        if(!empty($error))
            $this->setFlash('failure', $error->getMessage());
        
        $defaultData = array('username' => $session->get(SecurityContext::LAST_USERNAME));
        
        $form = $this->createFormBuilder($defaultData)
            ->add('username', 'text', array('label' => 'Username or E-mail Address'))
            ->add('password', 'password', array('label' => 'Password'))
            ->add('remember', 'checkbox', array('label' => 'Remember Me'))
            ->getForm();
        
        return array(
            'form'           => $form->createView(),
            'error'         => $error,
        );
    }
    /**
    * @Route("/logout", name="security_logout")
    * @Route("/logout/")
    * @Method({"GET"})
    * @Template()
    */
    public function logoutAction()
    {
        return array(
            
        );
    }
    /**
    * @Route("/check", name="security_check")
    * @Route("/check/")
    * @Method({"POST"})
    * @Template()
    */
    public function checkAction()
    {
        return array(
            
        );
    }
}