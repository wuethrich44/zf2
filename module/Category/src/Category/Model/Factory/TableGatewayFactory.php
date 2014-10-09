<?php

namespace Category\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Db\TableGateway\TableGateway;

class TableGatewayFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        $resultSet = $serviceLocator->get('Category\Model\ResultSet');

        return new TableGateway('categories', $dbAdapter, null, $resultSet);
    }
}
