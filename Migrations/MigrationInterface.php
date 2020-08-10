<?php


namespace App\Migrations;


use App\Db\DbInterface;

interface MigrationInterface
{
    public function makeMigration();

}