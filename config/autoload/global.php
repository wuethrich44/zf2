<?php

/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

// provided by webserver
$env = getenv('APP_ENV') ?: 'production';

return array(
    'module_config' => array(
        'upload_location' => __DIR__ . '/../../data/uploads',
        'max_file_size' => 100000000 // Bytes
    ),
    'view_manager' => array(
        'display_not_found_reason' => ($env == 'development'),
        'display_exceptions' => ($env == 'development'),
    ),
);
