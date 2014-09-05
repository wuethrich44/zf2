<?php

namespace File\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\Db\ResultSet\ResultSet;

class ResultSetFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $subject = $serviceLocator->get('File\Model\File');
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype($subject);

        return $resultSet;
    }

}
