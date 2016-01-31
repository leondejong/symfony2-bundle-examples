<?php

namespace Example\ApplicationBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    public function create(array $columns = array())
    {
        $entityName = $this->getEntityName();
        $entity = new $entityName();
        foreach($columns as $key => $value)
            if(method_exists($entityName, $this->methodName($key, 'set')))
                $entity->{$this->methodName($key, 'set')}($value);
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
    public function read($id = null)
    {
        if(empty($id))
            return $this->findAll();
        if(is_integer($id))
            return $this->find($id);
        return null;
    }
    public function update($id, array $columns = array())
    {
        $entityName = $this->getEntityName();
        $entity = $this->find($id);
        if(empty($entity))
            return;
        foreach($columns as $key => $value)
            if(method_exists($entityName, $this->methodName($key, 'set')))
                $entity->{$this->methodName($key, 'set')}($value);
        $this->getEntityManager()->flush();
        return $entity;
    }
    public function delete($id)
    {
        $entity = $this->find($id);
        if(empty($entity))
            return;
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
        return $entity;
    }
    public function methodName($name, $prefix = 'set')
    {
        return $prefix.implode(array_map('ucfirst', explode('_', $name)));
    }
}
