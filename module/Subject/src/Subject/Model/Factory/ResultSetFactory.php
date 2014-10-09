<?php

namespace Subject\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;

class ResultSetFactory implements FactoryInterface
{

    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $subject = $serviceLocator->get('Subject\Model\Subject');
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype($subject);

        return $resultSet;
    }
}
