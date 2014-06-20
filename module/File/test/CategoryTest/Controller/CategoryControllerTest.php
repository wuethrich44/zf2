<?php

namespace CategoryTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class CategoryControllerTest extends AbstractHttpControllerTestCase {

    public function setUp() {
        $this->setApplicationConfig(
                include dirname(dirname(dirname(dirname(dirname(__DIR__))))) . '/config/application.config.php'
        );
        parent::setUp();
    }

    protected function ZfcLoginMock() {
        $ZfcAuthService = $this->getMock('ZfcUser\Authentication\Storage\Db');

        $ZfcUserMock = $this->getMock('ZfcUser\Entity\User');

        $ZfcUserMock->expects($this->any())
                ->method('getId')
                ->will($this->returnValue('1'));

        $ZfcAuthService->expects($this->any())
                ->method('getIdentity')
                ->will($this->returnValue($ZfcUserMock));

        $ZfcAuthService->expects($this->any())
                ->method('hasIdentity')
                ->will($this->returnValue(true));

        $this->getApplicationServiceLocator()->setAllowOverride(true);
        $this->getApplicationServiceLocator()->setService('ZfcUser\Authentication\Storage\Db', $ZfcAuthService);
    }

    protected function CategoryTableMock() {
        $categoryTableMock = $this->getMockBuilder('File\Model\CategoryTable')
                ->disableOriginalConstructor()
                ->getMock();

        $categoryTableMock->expects($this->once())
                ->method('fetchAll')
                ->will($this->returnValue(array()));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('File\Model\CategoryTable', $categoryTableMock);
    }

    public function testIndexActionCanBeAccessed() {
        $this->CategoryTableMock();

        $this->ZfcLoginMock();

        $this->dispatch('/category');
        $this->assertResponseStatusCode(200);

        $this->assertModuleName('File');
        $this->assertControllerName('File\Controller\Category');
        $this->assertControllerClass('CategoryController');
        $this->assertMatchedRouteName('category');
    }

}
