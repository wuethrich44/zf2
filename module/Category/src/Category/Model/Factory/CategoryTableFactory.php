<?php

namespace Category\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Category\Model\CategoryTable;

class CategoryTableFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $tableGateway = $serviceLocator->get('Category\Model\TableGateway');
        
        return new CategoryTable($tableGateway);
    }

}
