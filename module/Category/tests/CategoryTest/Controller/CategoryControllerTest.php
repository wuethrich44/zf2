<?php

namespace CategoryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CategoryControllerTest extends AbstractHttpControllerTestCase {

    public function setUp() {

        putenv('APP_ENV=development');

        $this->setApplicationConfig(
                include dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/config/application.config.php'
        );

        parent::setUp();
    }

    public function testIndexActionCanBeAccessed() {
        throw new \PHPUnit_Framework_SkippedTestError();
    }

}
