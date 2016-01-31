<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ApplicationBundle\Entity\Object;
use Example\ApplicationBundle\Form\Type\ObjectType;

/**
 * Object controller.
 *
 * @Route("/administration/object")
 */
class ObjectController extends BaseController
{
    /**
     * Lists all Object entities.
     *
     * @Route("/", name="object")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExampleApplicationBundle:Object')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Object entity.
     *
     * @Route("/{id}/show", name="object_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Object entity.
     *
     * @Route("/new", name="object_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Object();
        $form   = $this->createForm(new ObjectType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Object entity.
     *
     * @Route("/create", name="object_create")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Object:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Object();
        $form = $this->createForm(new ObjectType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->addAcl($entity, 'ROLE_ADMIN');
            
            $this->setFlash('success', 'Object successfully created!');
            return $this->redirect($this->generateUrl('object_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Object entity.
     *
     * @Route("/{id}/edit", name="object_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }
        
        $this->checkAcl($entity);

        $editForm = $this->createForm(new ObjectType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Object entity.
     *
     * @Route("/{id}/update", name="object_update")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Object:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Object')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Object entity.');
        }
        
        $this->checkAcl($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ObjectType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->setFlash('success', 'Object successfully updated!');
            return $this->redirect($this->generateUrl('object_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Object entity.
     *
     * @Route("/{id}/delete", name="object_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExampleApplicationBundle:Object')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Object entity.');
            }
            
            $this->checkAcl($entity);
            $this->removeAcl($entity);

            $em->remove($entity);
            $em->flush();
        }
        $this->setFlash('success', 'Object successfully deleted!');
        return $this->redirect($this->generateUrl('object'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}