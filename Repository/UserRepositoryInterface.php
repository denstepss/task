<?php


namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    public function find($userId);
    public function save(User $user);
    public function update(User $user);
    public function delete($userId);
}