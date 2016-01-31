<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ApplicationBundle\Entity\User;
use Example\ApplicationBundle\Form\Type\UserType;

/**
 * User controller.
 *
 * @Route("/administration/user")
 */
class UserController extends BaseController
{
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExampleApplicationBundle:User')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @Route("/{id}/show", name="user_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        
        $entity->setViews($entity->getViews() + 1);
        $em->persist($entity);
        $em->flush();

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @Route("/new", name="user_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new User();
        $form = $this->getForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new User entity.
     *
     * @Route("/create", name="user_create")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:User:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new User();
        $form = $this->getForm($entity);
        $form->bind($request);

        if ($form->isValid()){
            $this->hashPassword($entity);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->addAcl($entity, 'ROLE_SUPER', $entity);
            
            $profile = $entity->getProfile();
            
            if($profile)
            {
                $profile->setUser($entity);
                $em->persist($profile);
                $em->flush();
                $this->addAcl($profile, 'ROLE_SUPER', $entity);
            }
            
            $this->setFlash('success', 'User successfully created!');
            return $this->redirect($this->generateUrl('user_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @Route("/{id}/edit", name="user_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        
        $this->checkAcl($entity);

        $editForm = $this->getForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing User entity.
     *
     * @Route("/{id}/update", name="user_update")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:User:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        
        $this->checkAcl($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->getForm($entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->hashPassword($entity);
            $em->persist($entity);
            $em->flush();
            $this->setFlash('success', 'User successfully updated!');
            return $this->redirect($this->generateUrl('user_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a User entity.
     *
     * @Route("/{id}/delete", name="user_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExampleApplicationBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }
            
            $this->checkAcl($entity);
            $this->removeAcl($entity);

            $em->remove($entity);
            $em->flush();
        }
        $this->setFlash('success', 'User successfully deleted!');
        return $this->redirect($this->generateUrl('user'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
    public function getForm($entity)
    {
        return $this->container->get('form.factory')->create('example_applicationbundle_usertype', $entity);
    }
}