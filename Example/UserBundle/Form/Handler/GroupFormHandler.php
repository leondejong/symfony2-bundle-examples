<?php

namespace Example\UserBundle\Form\Handler;

use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\GroupManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

use FOS\UserBundle\Form\Handler\GroupFormHandler as BaseGroupFormHandler;

class GroupFormHandler extends BaseGroupFormHandler
{
    protected $request;
    protected $groupManager;
    protected $form;

    public function __construct(FormInterface $form, Request $request, GroupManagerInterface $groupManager)
    {
        $this->form = $form;
        $this->request = $request;
        $this->groupManager = $groupManager;
    }

    public function process(GroupInterface $group = null)
    {
        if (null === $group) {
            $group = $this->groupManager->createGroup('');
        }

        $this->form->setData($group);

        if ('POST' === $this->request->getMethod()) {
            $this->form->bind($this->request);

            if ($this->form->isValid()) {
                $this->onSuccess($group);

                return true;
            }
        }

        return false;
    }

    protected function onSuccess(GroupInterface $group)
    {
        $this->groupManager->updateGroup($group);
    }
}
