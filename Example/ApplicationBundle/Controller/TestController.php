<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;

use Example\ApplicationBundle\Entity\Category;
use Example\ApplicationBundle\Entity\Page;

/**
 * Test controller.
 *
 * @Route("/test")
 */
class TestController extends BaseController
{
    /**
    * @Route("/", name="test")
    * @Route("/index")
    * @Route("/index/")
    * @Method({"GET", "POST"})
    * @Template()
    */
    public function indexAction()
    {
        return $this->test();
    }
    
    /**
    * @Route("/value", name="test_value", defaults={"value"="value"})
    * @Route("/value/", defaults={"value"="value"})
    * @Route("/value/{value}", name="test_value_value", requirements={"value" = "\w+"})
    * @Route("/value/{value}/", requirements={"value" = "\w+"})
    * @Method({"GET"})
    */
    public function valueAction($value = 'test')
    {
        return $this->render(
            'ExampleApplicationBundle:Test:index.html.twig', 
            array(
                'value' => $value
            )
        );
    }
    
    /**
    * @Route("/file/{name}.{_format}", name="test_file", defaults={"_format"="html"}, requirements={"_format" = "html|xml|json"})
    * @Method({"GET"})
    * @Template()
    */
    public function fileAction($name, $_format = 'html')
    {
        return array(
            'value' => "$name.$_format"
        );
    }
    
    /**
    * @Route("/forward", name="test_forward")
    * @Route("/forward/")
    * @Method({"GET"})
    */
    public function forwardAction()
    {
        return $this->forward(
            'ExampleApplicationBundle:Test:value',
            array(
                'value' =>'forward'
            )
        );
    }
    
    /**
    * @Route("/redirect", name="test_redirect")
    * @Route("/redirect/")
    * @Method({"GET"})
    */
    public function redirectAction()
    {
        $this->setFlash('success', 'Successfully redirected!');
        return $this->redirect(
            $this->generateUrl(
                'test_value_value',
                array(
                    'value' =>'redirect'
                    )
                )
            );
    }
    
    /**
    * @Route("/role", name="test_role")
    * @Route("/role/")
    * @Method({"GET"})
    * @Template()
    */
    public function roleAction()
    {
        return array();
    }
    
    /**
    * @Route("/super", name="test_super")
    * @Route("/super/")
    * @Method({"GET"})
    * @Secure(roles="ROLE_SUPER")
    */
    public function superAction()
    {
       if (!$this->get('security.context')->isGranted('ROLE_SUPER')) {
           throw new AccessDeniedException();
       }
        return new Response('super');
    }
    
    /**
    * @Route("/error", name="test_error")
    * @Route("/error/")
    * @Method({"GET"})
    */
    public function errorAction()
    {
        throw $this->createNotFoundException('This page does not exist');
    }
    
    /**
    * @Route("/form", name="test_form", defaults={"id"=0})
    * @Route("/form/", defaults={"id"=0})
    * @Route("/form/{id}", name="test_form_id", requirements={"id" = "\d+"})
    * @Route("/form/{id}/", requirements={"id" = "\d+"})
    * @Method({"GET", "POST"})
    */
    public function formAction($id = null)
    {
        $request = $this->getRequest();
        
        if($id)
        {
            $page = $this->getDoctrine()->getRepository('ExampleApplicationBundle:Page')->find($id);
        }
        else
        {
            $page = new Page();
            $page->setName($this->random())
                ->setTitle('new title')
                ->setTitle('new title')
                ->setDescription('new description');
        }
        
        $form = $this->createFormBuilder($page)
            ->add('title', 'text')
            ->add('description', 'textarea')
            ->getForm();
        
        if($request->isMethod('POST'))
        {
            $form->bind($request);
            
            if($form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($page);
                $entityManager->flush();
                $this->setFlash('success', 'Successfully saved!');
                return $this->redirect($this->generateUrl('test_form', array('id'=>$page->getId())));
            }
        }
        
        return $this->render('ExampleApplicationBundle:Test:form.html.twig', array(
            'id' => $id,
            'action' => 'test_form',
            'form' => $form->createView(),
        ));;
    }
    
    public static function random()
    {
        return substr(sha1(rand()), 0, 6);
    }
}