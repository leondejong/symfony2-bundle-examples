<?php

namespace Example\ApplicationBundle\Subscriber;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TablePrefix implements EventSubscriber
{
    protected $prefix = '';

    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }
    
    public function getSubscribedEvents()
    {
        return array('loadClassMetadata');
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        $classMetadata = $args->getClassMetadata();
 
        if(false !== strpos($classMetadata->namespace, 'ApplicationBundle'))
        {
            $classMetadata->setPrimaryTable(array('name' => $this->prefix . $classMetadata->getTableName()));
 
            foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping)
            {
                if($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY
                    && isset($classMetadata->associationMappings[$fieldName]['joinTable']['name']))
                {
                    $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
                }
            }
        }
    }
}
