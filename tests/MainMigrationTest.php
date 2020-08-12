<?php


namespace App\Tests;

require_once 'config.php';

use App\Db\PdoMysqlConnection;
use App\Migrations\MainMigration;
use PHPUnit\Framework\TestCase;

class MainMigrationTest extends TestCase
{
    protected static $dbh;

    public function testMigration()
    {
        $this->assertClassHasAttribute('connection', MainMigration::class);
        $pdoConnection = $this->createMock(PdoMysqlConnection::class);
        $pdoMock = $this->createMock(\PDO::class);
        $pdoConnection->method('getDb')
            ->willReturn($pdoMock);
        $migration = new MainMigration($pdoConnection);
        $this->assertNull($migration->makeMigration());
        $this->assertInstanceOf(PdoMysqlConnection::class, self::$dbh);
    }

    public function testMigrationFail()
    {
        $pdoMock = $this->createMock(\PDO::class);
        $pdoMock->method('exec')->willReturn(false);
        $this->assertFalse($pdoMock->exec('CREATE DATABASE IF NOT EXISTS ' . DB . ' CHARACTER SET ' . CHARSET . ' COLLATE utf8mb4_unicode_ci'));
        $this->expectException(\TypeError::class);
        new MainMigration($pdoMock);
    }


    public static function setUpBeforeClass(): void
    {
        self::$dbh = new PdoMysqlConnection();
        self::$dbh->connect();
    }
    public static function tearDownAfterClass(): void
    {
        self::$dbh = null;
    }

}