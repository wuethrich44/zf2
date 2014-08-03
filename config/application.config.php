<?php

return array(
    'modules' => array(
        'Application',
        'Download',
        'File',
        'TwbBundle',
        'ZfcBase',
        'ZfcAdmin',
        'ZfcUser',       
        'ZfcUserAdmin',
        'User',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'
        )
    ),
    'config_cache_enabled' => true,
    'config_cache_key' => 'module_config_cache',
    'cache_dir' => './data/cache',
);
