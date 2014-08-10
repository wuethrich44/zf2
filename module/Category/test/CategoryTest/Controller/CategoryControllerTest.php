<?php

namespace CategoryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CategoryControllerTest extends AbstractHttpControllerTestCase {

    protected $traceError = true;

    public function setUp() {
        $this->setApplicationConfig(
                include 'config' . DIRECTORY_SEPARATOR . 'application.config.php'
        );
        parent::setUp();
    }

    protected function mockZfcLogin() {
        $zfcAuthService = $this->getMock('ZfcUser\Authentication\Storage\Db');

        $zfcUserMock = $this->getMock('ZfcUser\Entity\User');

        $zfcUserMock->expects($this->any())
                ->method('getId')
                ->will($this->returnValue('1'));

        $zfcAuthService->expects($this->any())
                ->method('getIdentity')
                ->will($this->returnValue($zfcUserMock));

        $zfcAuthService->expects($this->any())
                ->method('hasIdentity')
                ->will($this->returnValue(true));

        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $this->getApplicationServiceLocator()->setService('ZfcUser\Authentication\Storage\Db', $zfcAuthService);
    }

    protected function mockCategoryTable() {
        $categoryTableMock = $this->getMockBuilder('File\Model\CategoryTable')
                ->disableOriginalConstructor()
                ->getMock();

        $categoryTableMock->expects($this->any())
                ->method('fetchAll')
                ->will($this->returnValue(array()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('File\Model\CategoryTable', $categoryTableMock);
    }

    public function testIndexActionCanBeAccessed() {
        $this->mockCategoryTable();

        $this->mockZfcLogin();

        $this->dispatch('/category');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('File');
        $this->assertControllerName('File\Controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');
    }

}
