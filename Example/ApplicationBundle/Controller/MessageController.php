<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ApplicationBundle\Entity\Message;
use Example\ApplicationBundle\Form\Type\MessageType;

/**
 * Message controller.
 *
 * @Route("/administration/message")
 */
class MessageController extends BaseController
{
    /**
     * Lists all Message entities.
     *
     * @Route("/", name="message")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExampleApplicationBundle:Message')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Message entity.
     *
     * @Route("/{id}/show", name="message_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Message')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Message entity.
     *
     * @Route("/new", name="message_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Message();
        $form   = $this->createForm(new MessageType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Message entity.
     *
     * @Route("/create", name="message_create")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Message:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Message();
        $form = $this->createForm(new MessageType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->addAcl($entity, 'ROLE_ADMIN');
            
            $this->setFlash('success', 'Message successfully created!');
            return $this->redirect($this->generateUrl('message_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Message entity.
     *
     * @Route("/{id}/edit", name="message_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Message')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }
        
        $this->checkAcl($entity);

        $editForm = $this->createForm(new MessageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Message entity.
     *
     * @Route("/{id}/update", name="message_update")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Message:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Message')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Message entity.');
        }
        
        $this->checkAcl($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MessageType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->setFlash('success', 'Message successfully updated!');
            return $this->redirect($this->generateUrl('message_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Message entity.
     *
     * @Route("/{id}/delete", name="message_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExampleApplicationBundle:Message')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Message entity.');
            }
            
            $this->checkAcl($entity);
            $this->removeAcl($entity);

            $em->remove($entity);
            $em->flush();
        }
        $this->setFlash('success', 'Message successfully deleted!');
        return $this->redirect($this->generateUrl('message'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}