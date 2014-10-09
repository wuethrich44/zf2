<?php

namespace File\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use File\Model\FileTable;

class FileTableFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $tableGateway = $serviceLocator->get('File\Model\TableGateway');

        return new FileTable($tableGateway);
    }
}
