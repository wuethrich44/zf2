<?php

use Zend\Stdlib\ArrayUtils;

// provided from websever
$env = getenv('APP_ENV') ? : 'production';

$config = array(
    'modules' => array(
        'Application',
        'Download',
        'File',
        'Subject',
        'Category',
        'ZfcBase',
        'ZfcUser',
        'User',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor'
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php'
        ),
        'cache_dir' => 'data/cache/',
    ),
);

$localAppConfigFilename = 'config/application.config.' . $env . '.php';

if (is_readable($localAppConfigFilename)) {
    $config = ArrayUtils::merge($config, require($localAppConfigFilename));
}

return $config;
