<?php

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// provided from webserver
$env = getenv('APP_ENV') ? : 'production';

define('ZF_CLASS_CACHE', 'data/cache/classes.php.cache');

if ($env == 'production') {
      if (file_exists(ZF_CLASS_CACHE)) require_once ZF_CLASS_CACHE;
}

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
