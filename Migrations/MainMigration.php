<?php


namespace App\Migrations;


use App\Db\DbInterface;

class MainMigration implements MigrationInterface
{
    protected $connection = null;

    public function __construct(DbInterface $connection){
        $this->connection = $connection->getDb();
    }

    public function makeMigration(){

        if($this->connection) {
            $this->connection->exec('CREATE DATABASE IF NOT EXISTS ' . DB . ' CHARACTER SET ' . CHARSET . ' COLLATE utf8mb4_unicode_ci');
            $this->connection->query('use ' . DB);
            $this->connection->exec('CREATE TABLE IF NOT EXISTS users (`id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                    `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,`lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL, 
                        `patronymic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                        `currency` CHAR(3) NOT NULL ,`sum` decimal(10,2) NOT NULL, PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        }

    }

}