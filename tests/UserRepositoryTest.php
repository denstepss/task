<?php


namespace App\Tests;

require_once 'config.php';

use App\Db\PdoMysqlConnection;
use App\Entity\User;
use App\Repository\UserRepository;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    protected static $dbh;


    public function setUp(): void
    {
        if (self::$dbh === null) {
            self::$dbh = new PdoMysqlConnection();
            self::$dbh->connect();
        }

        self::$dbh->getDb()->beginTransaction();

    }

    public function teardown(): void
    {
        self::$dbh->getDb()->rollBack();
    }

    public function testSave(){
        $this->assertNull($this->saveData());
    }

    public function saveData(){
        $repository = new UserRepository(self::$dbh);
        $user = new User();
        $user->setFirstname('firstname');
        $user->setLastname('lastname');
        $user->setPatronymic('patronymic');
        $user->setCurrency('USD');
        $user->setEmail('test@gmail.com');
        $user->setSum(11.88);
        return $repository->save($user);
    }

    public function testFind(){
        $userRepository = new UserRepository(self::$dbh);
        $this->assertEquals(null, $userRepository->find(self::$dbh->getDb()->lastInsertId()));
        $this->saveData();
        $this->assertInstanceOf(User::class, $userRepository->find(self::$dbh->getDb()->lastInsertId()));

    }

    public function testFindAll(){
        $userRepository = new UserRepository(self::$dbh);
        $this->assertIsArray($this->createMock(UserRepository::class)->findAll());
        $this->assertIsArray($userRepository->findAll());
    }

    public function testFindBy(){
        $userRepository = new UserRepository(self::$dbh);
        $this->isEmpty($this->createMock(UserRepository::class)->findBy(['currency' => 'USD']));
        $this->isEmpty($userRepository->findBy(['currency' => 'USD']));
        $this->assertIsArray($userRepository->findBy(['currency' => 'USD']));
    }

    public function testUpdate(){
        $this->assertNotFalse($this->createMock(UserRepository::class)->save(new User()));
        $this->assertNull($this->createMock(UserRepository::class)->save(new User()));
    }


}