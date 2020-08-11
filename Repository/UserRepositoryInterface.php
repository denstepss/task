<?php


namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function find(int $userId);
    public function findAll();
    public function findBy(array $criteria = [], ?array $orderBy = null, $limit = null, $offset = null);
    public function save(User $user);
    public function update(User $user);
    public function delete(int $userId);
}