<?php

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\Validator\AbstractValidator;

class Module
{

    public function onBootstrap(MvcEvent $e)
    {
        $translator = $e->getApplication()->getServiceManager()->get('translator');
        $translator->addTranslationFile(
            'phpArray',
            __DIR__ . '/language/de/Zend_Validate.php',
            'default',
            'de_DE'
        );
        AbstractValidator::setDefaultTranslator($translator);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' .
                    __NAMESPACE__
                )
            )
        );
    }
}
