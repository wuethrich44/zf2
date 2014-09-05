<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Download\Controller\Download' => 'Download\Controller\DownloadController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'download' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/[:subject][/:category][/:file]',
                    'defaults' => array(
                        'controller' => 'Download\Controller\Download',
                        'action' => 'index',
                    ),
                ),
            ),
            'upload' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/upload',
                    'defaults' => array(
                        'controller' => 'Download\Controller\Download',
                        'action' => 'upload',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'template_map' => array(
            'download/subject/index' => __DIR__ . '/../view/download/subject/index.phtml',
            'download/category/index' => __DIR__ . '/../view/download/category/index.phtml',
            'download/file/index' => __DIR__ . '/../view/download/file/index.phtml',
        ),
    ),
);
