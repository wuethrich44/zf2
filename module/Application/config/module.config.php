<?php

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Download\Controller\Download',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Download',
                'route' => 'download',
            ),
            array(
                'label' => 'Upload',
                'route' => 'file',
                'action' => 'add',
            ),
            array(
                'label' => 'Module',
                'route' => 'subject',
                'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'subject',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'subject',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'subject',
                        'action' => 'delete',
                    ),
                ),
            ),
            array(
                'label' => 'Kategorien',
                'route' => 'category',
                'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'category',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'category',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'category',
                        'action' => 'delete',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'Zend\Db\Adapter\Adapter' => function ($sm) {
        $config = $sm->get('Config');
        $dbParams = $config ['dbParams'];

        return new Zend\Db\Adapter\Adapter(array(
            'driver' => 'pdo',
            'dsn' => 'mysql:dbname=' . $dbParams ['database'] . ';host=' . $dbParams ['hostname'],
            'database' => $dbParams ['database'],
            'username' => $dbParams ['username'],
            'password' => $dbParams ['password'],
            'hostname' => $dbParams ['hostname'],
            'driver_options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                PDO::ATTR_PERSISTENT => true
            )
        ));
    },
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'de_DE',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'view_manager' => array(
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
