<?php

namespace Category;

class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Category\Model\Category' => 'Category\Model\Factory\CategoryFactory',
                'Category\Model\CategoryTable' => 'Category\Model\Factory\CategoryTableFactory',
                'Category\Model\ResultSet' => 'Category\Model\Factory\ResultSetFactory',
                'Category\Model\TableGateway' => 'Category\Model\Factory\TableGatewayFactory',
            )
        );
    }
}
