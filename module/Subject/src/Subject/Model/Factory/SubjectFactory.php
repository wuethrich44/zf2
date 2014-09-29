<?php

namespace Subject\Model\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use Subject\Model\Subject;

class SubjectFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $dbAdapter = $serviceLocator->get('Zend\Db\Adapter\Adapter');
        
        return new Subject($dbAdapter);
    }

}
