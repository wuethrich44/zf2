<?php

return array(
    // TODO all config like this structure
    'controllers' => array(
        'invokables' => array(
            'Subject\Controller\Subject' => 'Subject\Controller\SubjectController'
        )
    ),
    'router' => array(
        'routes' => array(
            'subject' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/subject[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+'
                    ),
                    'defaults' => array(
                        'controller' => 'Subject\Controller\Subject',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'subject' => __DIR__ . '/../view'
        )
    )
);
