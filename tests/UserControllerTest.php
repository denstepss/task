<?php


namespace App\Tests;

require_once 'config.php';

use App\Controller\UserController;
use App\Entity\User;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserControllerTest extends TestCase
{

        public function  testControllerInit()
        {
            $this->assertNull($this->controller->indexAction());
            $this->getActualOutputForAssertion();
            $this->assertStringContainsString('html', $this->getActualOutput());
        }

        /**
         * @runInSeparateProcess
         */
        public function  testControllerEdit()
        {
            $this->assertNull($this->controller->editAction([]));
            $this->getActualOutputForAssertion();
            $this->assertStringContainsString('', $this->getActualOutput());
            $_GET['id'] = 1;
            $this->assertNull($this->controller->editAction($_GET));
            $this->assertStringContainsString('html', $this->getActualOutput());
        }

        /**
         * @runInSeparateProcess
         */
        public function  testSearchAction()
        {
            $this->assertNull($this->controller->searchAction([]));
            $this->getActualOutputForAssertion();
            $this->assertStringContainsString('', $this->getActualOutput());
            $_GET['id'] = 1;
            $this->assertNull($this->controller->searchAction($_GET));
            $this->assertStringContainsString('html', $this->getActualOutput());
        }

        /**
         * @runInSeparateProcess
         */
        public function  testUpdateAction()
        {
            $this->assertNull($this->controller->updateAction([]));
            $this->getActualOutputForAssertion();
            $this->assertArrayNotHasKey('id',$_GET);
            $this->assertNull($this->controller->searchAction($_GET));
            $this->assertStringContainsString('html', $this->getActualOutput());
        }

        /**
         * @runInSeparateProcess
         */
        public function  testPostControllerRedirectAction()
        {
            $this->assertNull($this->controller->createAction(['err']));
            $this->assertEquals(-1,$this->getStatus());
        }


        protected $controller;


        public function setUp(): void
        {
            if ($this->controller === null) {
                $mockRepository = $this->createMock(UserRepository::class);
                $this->controller = new UserController($mockRepository);
            }

        }

        public function teardown(): void
        {
            $this->controller = null;
        }

}