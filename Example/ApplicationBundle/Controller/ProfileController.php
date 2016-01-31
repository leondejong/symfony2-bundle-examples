<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ApplicationBundle\Entity\Profile;
use Example\ApplicationBundle\Form\Type\ProfileType;

/**
 * Profile controller.
 *
 * @Route("/administration/profile")
 */
class ProfileController extends BaseController
{
    /**
     * Lists all Profile entities.
     *
     * @Route("/", name="profile")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExampleApplicationBundle:Profile')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Profile entity.
     *
     * @Route("/{id}/show", name="profile_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Profile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profile entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Profile entity.
     *
     * @Route("/new", name="profile_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Profile();
        $form   = $this->createForm(new ProfileType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Profile entity.
     *
     * @Route("/create", name="profile_create")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Profile:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Profile();
        $form = $this->createForm(new ProfileType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->addAcl($entity, 'ROLE_ADMIN');
            
            $this->setFlash('success', 'Profile successfully created!');
            return $this->redirect($this->generateUrl('profile_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Profile entity.
     *
     * @Route("/{id}/edit", name="profile_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Profile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profile entity.');
        }
        
        $this->checkAcl($entity);

        $editForm = $this->createForm(new ProfileType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Profile entity.
     *
     * @Route("/{id}/update", name="profile_update")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Profile:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Profile')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Profile entity.');
        }
        
        $this->checkAcl($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ProfileType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->setFlash('success', 'Profile successfully updated!');
            return $this->redirect($this->generateUrl('profile_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Profile entity.
     *
     * @Route("/{id}/delete", name="profile_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExampleApplicationBundle:Profile')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Profile entity.');
            }
            
            $this->checkAcl($entity);
            $this->removeAcl($entity);

            $em->remove($entity);
            $em->flush();
        }
        $this->setFlash('success', 'Profiel successfully deleted!');
        return $this->redirect($this->generateUrl('profile'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}