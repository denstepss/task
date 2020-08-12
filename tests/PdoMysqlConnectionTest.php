<?php


namespace App\Tests;

require_once 'config.php';

use App\Db\PdoMysqlConnection;
use PHPUnit\Framework\TestCase;

class PdoMysqlConnectionTest extends TestCase
{
    protected static $dbh;

    public function testRightConnection()
    {
        $this->assertClassHasAttribute('db', PdoMysqlConnection::class);
        $connection = new PdoMysqlConnection();
        $this->assertEquals(NULL, $connection->getDb());
        $this->assertNull($connection->connect());
        $this->assertInstanceOf(\PDO::class, $connection->getDb());
    }

    public function testException()
    {
        $this->expectException(\PDOException::class);
        self::$dbh->query('use NOTCREATEDTABLE');
        new \PDO('mysql::memory');
    }

    public static function setUpBeforeClass(): void
    {
        $pdo = new \PDO('mysql:host=' . HOST . ';charset=' . CHARSET, USER, PASSWORD);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->query('use ' . DB);
        self::$dbh = $pdo;
    }
    public static function tearDownAfterClass(): void
    {
        self::$dbh = null;
    }

}