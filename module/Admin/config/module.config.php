<?php

return array(
    'bjyauthorize' => array(
        'guards' => array(
            'BjyAuthorize\Guard\Controller' => array(
                array('controller' => 'ZfcAdmin\Controller\AdminController', 'roles' => array()),
            ),
        ),
    ),
);