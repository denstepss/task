<?php


namespace App\Tests;

require_once 'config.php';

use App\Entity\User;
use App\Provider\MemcacheProvider;
use PHPUnit\Framework\TestCase;

class MemcacheProviderTest extends TestCase
{
    protected static $memcache;

    public function testCacheProvider()
    {
        $this->assertClassHasAttribute('cache', MemcacheProvider::class);
        $this->assertIsBool(self::$memcache->set('test',1));
    }

    /**
     * @dataProvider storedData
     */
    public function testStore(array $data)
    {
        $this->assertIsInt(self::$memcache->get('test'));
        $this->assertEquals(null, self::$memcache->delete(['test']));
        self::$memcache->set('test',$data['test']);
        $this->assertIsFloat(self::$memcache->get('test'));
    }

    public function storedData ()
    {
        return [
            [['test' => 11.1]],
        ];
    }


    public static function setUpBeforeClass(): void
    {
        self::$memcache = new MemcacheProvider();
    }
    public static function tearDownAfterClass(): void
    {
        self::$memcache = null;
    }

}