<?php

return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'zfcuser' => __DIR__ . '/../view',
        ),
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => 'vendor/zf-commons/zfc-user/src/ZfcUser/language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
);
