<?php

return array(
    // TODO all config like this structure
    'controllers' => array(
        'invokables' => array(
            'File\Controller\File' => 'File\Controller\FileController',
            'File\Controller\Category' => 'File\Controller\CategoryController',
            'File\Controller\Subject' => 'File\Controller\SubjectController'
        )
    ),
    'router' => array(
        'routes' => array(
            'file' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/file[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'File\Controller\File',
                        'action' => 'index'
                    )
                )
            ),
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/category[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'File\Controller\Category',
                        'action' => 'index'
                    )
                )
            ),
            'subject' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/subject[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'File\Controller\Subject',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view'
        )
    )
);
