<?php

namespace Subject\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Subject\Model\SubjectTable;

class SubjectTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('Subject\Model\TableGateway');

        return new SubjectTable($tableGateway);
    }
}
