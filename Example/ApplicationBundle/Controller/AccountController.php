<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ApplicationBundle\Form\Type\RegistrationType;
use Example\ApplicationBundle\Form\Model\Registration;

/**
 * Account controller.
 *
 * @Route("/account")
 */
class AccountController extends BaseController
{
    /**
     * Register page.
     *
     * @Route("/register", name="account_register")
     * @Method("GET")
     * @Template("ExampleApplicationBundle:Account:register.html.twig")
     */
    public function registerAction()
    {
        $form = $this->createForm(
            new RegistrationType(),
            new Registration()
        );

        return $this->render(
            'ExampleApplicationBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
    
    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="account_create")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Account:register.html.twig")
     */
    public function createAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->bind($this->getRequest());

        if ($form->isValid())
        {
            $registration = $form->getData();
            $user = $registration->getUser();
            
            $this->hashPassword($user);
            
            // Add group
            $group = $em->getRepository('ExampleApplicationBundle:Group')->findOneByRole('ROLE_USER');
            $user->addGroup($group);
            
            $em->persist($user);
            $em->flush();
            
            // log user in
            $token = new UsernamePasswordToken($user, null, 'user', array('ROLE_USER'));
            $this->get('security.context')->setToken($token);
            
            $this->addAcl($user, 'ROLE_SUPER', $user);
            
            $this->setFlash('success', 'User successfully registered!');
            return $this->redirect($this->generateUrl('index'));
        }

        return $this->render(
            'ExampleApplicationBundle:Account:register.html.twig',
            array('form' => $form->createView())
        );
    }
}