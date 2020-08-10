<?php


namespace App\Provider;


interface CacheProviderInterface
{
    public function set($key,$value);
    public function delete($key);
    public function get($key);
}