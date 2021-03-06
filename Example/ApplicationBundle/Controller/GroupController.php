<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Example\ApplicationBundle\Entity\Group;
use Example\ApplicationBundle\Form\Type\GroupType;

/**
 * Group controller.
 *
 * @Route("/administration/group")
 */
class GroupController extends BaseController
{
    /**
     * Lists all Group entities.
     *
     * @Route("/", name="group")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ExampleApplicationBundle:Group')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Group entity.
     *
     * @Route("/{id}/show", name="group_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Group entity.
     *
     * @Route("/new", name="group_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Group();
        $form   = $this->createForm(new GroupType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Group entity.
     *
     * @Route("/create", name="group_create")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Group:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Group();
        $form = $this->createForm(new GroupType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            $this->addAcl($entity, 'ROLE_SUPER');
            
            $this->setFlash('success', 'Group successfully created!');
            return $this->redirect($this->generateUrl('group_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @Route("/{id}/edit", name="group_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }
        
        $this->checkAcl($entity);

        $editForm = $this->createForm(new GroupType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Group entity.
     *
     * @Route("/{id}/update", name="group_update")
     * @Method("POST")
     * @Template("ExampleApplicationBundle:Group:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ExampleApplicationBundle:Group')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Group entity.');
        }
        
        $this->checkAcl($entity);

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new GroupType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();
            $this->setFlash('success', 'Group successfully updated!');
            return $this->redirect($this->generateUrl('group_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Group entity.
     *
     * @Route("/{id}/delete", name="group_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ExampleApplicationBundle:Group')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Group entity.');
            }
            
            $this->checkAcl($entity);
            $this->removeAcl($entity);

            $em->remove($entity);
            $em->flush();
        }
        $this->setFlash('success', 'Group successfully deleted!');
        return $this->redirect($this->generateUrl('group'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}