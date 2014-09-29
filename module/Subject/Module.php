<?php

namespace Subject;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' .
                    __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Subject\Model\Subject' => 'Subject\Model\Factory\SubjectFactory',
                'Subject\Model\SubjectTable' => 'Subject\Model\Factory\SubjectTableFactory',
                'Subject\Model\ResultSet' => 'Subject\Model\Factory\ResultSetFactory',
                'Subject\Model\TableGateway' => 'Subject\Model\Factory\TableGatewayFactory',
            )
        );
    }

}
