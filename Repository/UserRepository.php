<?php


namespace App\Repository;

use App\Db\DbInterface;
use App\Entity\User;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private $db;

    public function __construct(DbInterface $db)
    {
        $this->db = $db->getDb();
    }

    public function find($userId){
        return $this->db->query('SELECT * FROM users WHERE id ='.$userId)->fetchObject(User::class);
    }

    public function findBy(array $criteria = [], ?array $orderBy = null, $limit = null, $offset = null){
        $where = '';
        foreach ($criteria as $option => $value){
            $where .= "`$option` = '$value' AND ";
        }
        $where = rtrim($where, "AND ");
        $orderBy = $orderBy ? ' ORDER BY '.key($orderBy).' '. $orderBy[key($orderBy)]: '';
        $limit = $limit ? ' LIMIT '.$limit : '';
        $offset = $offset ? ' OFFSET '.$offset : '';
        return $this->db->query('SELECT * FROM users '.($where == '' ? '' : 'WHERE '.$where).$orderBy.$limit.$offset)->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function save(User $user){
        $sql = "INSERT INTO users (email, currency, sum,  firstname, lastname, patronymic) 
                VALUES (:email, :currency, :sum,  :firstname, :lastname, :patronymic)";
        return $this->db->prepare($sql)->execute([':email' => $user->getEmail(), ':currency' => $user->getCurrency(),
            ':sum' => $user->getSum(), ':firstname' => $user->getFirstname(), ':lastname' => $user->getLastname(),
            ':patronymic' => $user->getPatronymic()]);
    }

    public function update(User $user){
        $query = 'UPDATE users SET email = :email, currency  = :currency, sum = :sum, 
          firstname = :firstname, lastname  = :lastname, patronymic = :patronymic WHERE id = :id';

        return $this->db->prepare($query)->execute([':email' => $user->getEmail(), ':currency'  => $user->getCurrency(),
            ':sum' => $user->getSum(), ':firstname' => $user->getFirstname(), ':lastname' => $user->getLastname(),
            ':patronymic' => $user->getPatronymic(), ':id' => $user->getId()]);
    }

    public function delete($userId){
        return $this->db->prepare('DELETE FROM users WHERE id = :id')->execute([':id' => $userId]);
    }

}