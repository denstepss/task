<?php


namespace App\Provider;


interface CacheProviderInterface
{
    public function set($key,$value);
    public function delete(array $keys);
    public function get($key);
}