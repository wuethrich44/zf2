<?php

namespace User;

use Zend\Filter\PregReplace;

class Module {

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function onBootstrap($e) {
        $events = $e->getApplication()->getEventManager()->getSharedManager();
        $config = $e->getApplication()->getServiceManager()->get('Config');

        $onlyHsluEmail = $config['user_registration']['only_hslu_email'];

        // Modify RegisterForm
        $events->attach('ZfcUser\Form\Register', 'init', function($e) use ($onlyHsluEmail) {
            $form = $e->getTarget();
            if ($form->has('username')) {
                $form->get('username')->setAttribute('class', 'form-control');
            }
            if ($form->has('display_name')) {
                $form->get('display_name')->setAttribute('class', 'form-control');
            }
            $form->get('email')->setAttribute('class', 'form-control');
            $form->get('password')->setAttribute('class', 'form-control');
            $form->get('passwordVerify')->setAttribute('class', 'form-control');
            $form->get('submit')->setAttribute('class', 'btn btn-default');

            if ($onlyHsluEmail) {
                $form->remove('email');
                $email = new \Zend\Form\Element\Text('email', array('label' => 'Email', 'add-on-append' => '@stud.hslu.ch'));
                $form->add($email, array('priority' => 1));
            }
        });

        $events->attach('ZfcUser\Form\RegisterFilter', 'init', function($e) use ($onlyHsluEmail) {
            $filter = $e->getTarget();
            if ($onlyHsluEmail) {
                // Attach @stud.hslu.ch at the end of the email
                $filter->get('email')->getFilterChain()->attach(new PregReplace(array(
                    'pattern' => '/$/',
                    'replacement' => '@stud.hslu.ch',
                )));
            }
        });

        // Modify LoginForm
        $events->attach('ZfcUser\Form\Login', 'init', function($e) {
            $form = $e->getTarget();
            $form->get('identity')->setAttribute('class', 'form-control');
            $form->get('credential')->setAttribute('class', 'form-control');
            $form->get('submit')->setAttribute('class', 'btn btn-default');
        });
    }

}
