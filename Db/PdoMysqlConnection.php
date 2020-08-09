<?php

namespace App\Db;

include_once 'config.php';

class PdoMysqlConnection implements DbInterface
{
    protected $db = null;

    public function connect()
    {
        try {
            if(is_null($this->db)) {
                $this->db = new \PDO('mysql:host=' . HOST . ';charset=' . CHARSET, USER, PASSWORD);
                $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->db->exec('CREATE DATABASE IF NOT EXISTS ' . DB . ' CHARACTER SET ' . CHARSET . ' COLLATE utf8mb4_unicode_ci');
                $this->db->query('use ' . DB);
                $this->db->exec('CREATE TABLE IF NOT EXISTS users (`id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,`lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
                        `patronymic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `currency` CHAR(3) NOT NULL ,`sum` decimal(10,2) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
            }
        } catch (\PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
    }

    public function getDb()
    {
        if($this->db instanceof \PDO) {
            return $this->db;
        }
        return false;
    }
}