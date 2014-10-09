<?php

namespace Category\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;

class ResultSetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $subject = $serviceLocator->get('Category\Model\Category');
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype($subject);

        return $resultSet;
    }
}
