<?php


namespace App\Db;


interface DbInterface
{
    public function connect();
    public function getDb();
}