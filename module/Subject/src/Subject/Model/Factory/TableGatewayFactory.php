<?php

namespace Subject\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;

class TableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSet = $serviceLocator->get('Subject\Model\ResultSet');

        return new TableGateway('subjects', $dbAdapter, null, $resultSet);
    }
}
