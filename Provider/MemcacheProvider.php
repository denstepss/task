<?php


namespace App\Provider;

class MemcacheProvider implements CacheProviderInterface
{
    protected $cache = null;

    public function __construct () {

        try {
            $memcache = new \Memcache();
            $memcache->connect(HOST_MEMCACHE, PORT_MEMCACHE);
            $this->cache = $memcache;
        }
        catch (\Exception $e){
            echo "Failed: " . $e->getMessage() . PHP_EOL;
        }

    }

    public function set($key, $value)
    {
        return $this->cache->set(md5($key), $value);
    }

    public function delete($key)
    {
        $this->cache->delete(md5($key));
    }

    public function get($key)
    {
       return $this->cache->get(md5($key));
    }
}