<?php

namespace Category;

use Category\Model\Category;
use Category\Model\CategoryTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

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
                'Category\Model\CategoryTable' => function ($sm) {
                    $tableGateway = $sm->get('CategoryTableGateway');
                    $table = new CategoryTable($tableGateway);
                    return $table;
                },
                'CategoryTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(
                    $sm->get('Category'));
                    return new TableGateway('categories', $dbAdapter, null, $resultSetPrototype);
                },
                'Category' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $category = new Category();
                    $category->setDbAdapter($dbAdapter);
                    return $category;
                },
            )
        );
    }
}