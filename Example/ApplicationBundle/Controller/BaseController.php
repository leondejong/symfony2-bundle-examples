<?php

namespace Example\ApplicationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Acl\Domain\ObjectIdentity;
use Symfony\Component\Security\Acl\Domain\UserSecurityIdentity;
use Symfony\Component\Security\Acl\Domain\RoleSecurityIdentity;
use Symfony\Component\Security\Acl\Permission\MaskBuilder;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Example\ApplicationBundle\Entity\Base;
use Example\ApplicationBundle\Entity\User;

class BaseController extends Controller
{
    protected function addAcl(Base $entity, $role = 'ROLE_SUPER', User $user = null)
    {
        $aclProvider = $this->get('security.acl.provider');
        $securityContext = $this->get('security.context');
        
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $acl = $aclProvider->createAcl($objectIdentity);
        
        if(!$user)
            $user = $securityContext->getToken()->getUser();
        
        $securityIdentity = UserSecurityIdentity::fromAccount($user);
        $acl->insertObjectAce($securityIdentity, MaskBuilder::MASK_OPERATOR);
        
        $roleSecurityIdentity = new RoleSecurityIdentity($role);
        $acl->insertObjectAce($roleSecurityIdentity, MaskBuilder::MASK_MASTER);
        
        $aclProvider->updateAcl($acl);
    }
    
    protected function checkAcl(Base $entity)
    {
        $securityContext = $this->get('security.context');

        if(false === $securityContext->isGranted('EDIT', $entity))
        {
            throw new AccessDeniedException();
        }
    }
    
    protected function removeAcl(Base $entity)
    {
        $aclProvider = $this->get('security.acl.provider');
        $objectIdentity = ObjectIdentity::fromDomainObject($entity);
        $aclProvider->deleteAcl($objectIdentity);
    }
    
    public function hashPassword(&$entity)
    {
        $factory = $this->get('security.encoder_factory');
        $encoder = $factory->getEncoder($entity);
        $password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
        $entity->setPassword($password);
    }
    
    public function setFlash($type, $message)
    {
        $this->get('session')->getFlashBag()->add($type, $message);
    }
}