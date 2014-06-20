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

    protected function mockCategoryTable() {
        $categoryTableMock = $this->getMockBuilder('File\Model\CategoryTable')
                ->disableOriginalConstructor()
                ->getMock();

        $categoryTableMock->expects($this->any())
                ->method('fetchAll')
                ->will($this->returnValue(array()));

        $categoryTableMock->expects($this->any())
                ->method('saveCategory')
                ->will($this->returnValue(null));

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

    public function testAddActionRedirectsAfterValidPost() {
        $this->mockZfcLogin();
        $categoryTableMock = $this->getMockBuilder('File\Model\CategoryTable')
                ->disableOriginalConstructor()
                ->getMock();

        $categoryTableMock->expects($this->once())
                ->method('saveCategory')
                ->will($this->returnValue(null));

        $serviceManager = $this->getApplicationServiceLocator();
        $serviceManager->setAllowOverride(true);
        $serviceManager->setService('File\Model\CategoryTable', $categoryTableMock);

        $postData = array(
            'categoryID' => '',
            'name' => 'Led Zeppelin',
        );
        $this->dispatch('/category/add', 'POST', $postData);
        $this->assertResponseStatusCode(302);

        $this->assertRedirectTo('/category/');
    }

}
