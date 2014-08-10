<?php

namespace File;

use File\Model\Category;
use File\Model\CategoryTable;
use File\Model\File;
use File\Model\FileTable;
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
                'File\Model\CategoryTable' => function ($sm) {
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
                'File\Model\FileTable' => function ($sm) {
            $tableGateway = $sm->get('FileTableGateway');
            $table = new FileTable($tableGateway);
            return $table;
        },
                'FileTableGateway' => function ($sm) {
            $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
            $resultSetPrototype = new ResultSet();
            $resultSetPrototype->setArrayObjectPrototype(
                    new File());
            return new TableGateway('files', $dbAdapter, null, $resultSetPrototype);
        }
            )
        );
    }

}
