<?php

return array(
    'modules' => array(
        // 3rd part modules
        'TwbBundle',
        'ZfcBase',
        'ZfcAdmin',
        'ZfcUser',       
        'ZfcUserAdmin',
        'BjyAuthorize',
        
        // Custom modules
        'Application',
        'Download',
        'File',
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
