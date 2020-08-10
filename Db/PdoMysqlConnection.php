<?php

namespace App\Db;

use App\Migrations\MainMigration;

class PdoMysqlConnection implements DbInterface
{
    protected $db = null;

    public function connect()
    {
        try {
            try {
                if(is_null($this->db)) {
                    $this->db = new \PDO('mysql:host=' . HOST . ';charset=' . CHARSET, USER, PASSWORD);
                    $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                    $this->db->query('use ' . DB);
                }
            } catch (\PDOException $e) {
                $migration = new MainMigration($this);
                $migration->makeMigration();
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