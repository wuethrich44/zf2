<?php

namespace FileTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class AlbumControllerTest extends AbstractHttpControllerTestCase {

    public function setUp() {
        $this->setApplicationConfig(
                include '/config/application.config.php'
        );
        parent::setUp();
    }

    public function testIndexActionCanBeAccessed() {
        $this->dispatch('/file');

        $this->assertModuleName('File');
        $this->assertControllerName('File\Controller\File');
        $this->assertControllerClass('FileController');
        $this->assertMatchedRouteName('file');
    }

}
