<?php

declare(strict_types=1);

namespace App\Repository;

use App\Db\DbInterface;
use App\Entity\User;
use App\Provider\MemcacheProvider;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private $db = null;
    protected $cache = null;


    public function __construct(DbInterface $db)
    {
        $this->db = $db->getDb();
        if(ENABLE_MEMCACHE){
            $this->cache = new MemcacheProvider();
        }
    }

    public function find(int $userId)
    {
        if($this->cache){
            if(!empty($cached = $this->cache->get($userId))) { return $cached; }
            $user = $this->db->query('SELECT * FROM users WHERE id ='.$userId)->fetchObject(User::class);
            $this->cache->set($userId, $user);
            return $user;
        }
        else{
            return $this->db->query('SELECT * FROM users WHERE id ='.$userId)->fetchObject(User::class);
        }

    }

    public function findAll(): array
    {
        if($this->cache && !empty($data = $this->cache->get('all'))) { return $data; }
        $result =  $this->findBy([],['id' => 'DESC']);
        if($this->cache) {
            $this->cache->set('all', $result);
        }
        return $result;
    }

    public function findBy(array $criteria = [], ?array $orderBy = null, $limit = null, $offset = null): array
    {
        $where = '';
        foreach ($criteria as $option => $value){
            if(!empty($value)) {
                $where .= "`$option` = '$value' AND ";
            }
        }
        $where = rtrim($where, "AND ");
        $orderBy = $orderBy ? ' ORDER BY '.key($orderBy).' '. $orderBy[key($orderBy)]: '';
        $limit = $limit ? ' LIMIT '.$limit : '';
        $offset = $offset ? ' OFFSET '.$offset : '';

        return $this->db->query('SELECT * FROM users '.($where == '' ? '' : 'WHERE '.$where).$orderBy.$limit.$offset)->fetchAll(PDO::FETCH_CLASS, User::class);
    }

    public function findByLike(string $query): array
    {

        foreach (explode(" ", $query) as $word) {
            $sql = "SELECT * FROM `users` WHERE `firstname` LIKE :keyword OR `lastname` LIKE :keyword
            OR `patronymic` LIKE :keyword OR `email` LIKE :keyword  OR `sum` LIKE :keyword OR `currency` LIKE :keyword";
            $q = $this->db->prepare($sql);
            $q->bindValue(':keyword', "%$word%");
        }
        $q->execute();

        return $q->fetchAll(PDO::FETCH_CLASS, User::class);

    }

    public function save(User $user)
    {
        $sql = "INSERT INTO users (email, currency, sum,  firstname, lastname, patronymic) 
                VALUES (:email, :currency, :sum,  :firstname, :lastname, :patronymic)";
         $this->db->prepare($sql)->execute([':email' => $user->getEmail(), ':currency' => $user->getCurrency(),
            ':sum' => $user->getSum(), ':firstname' => $user->getFirstname(), ':lastname' => $user->getLastname(),
            ':patronymic' => $user->getPatronymic()]);

         if($this->cache){
             $user->setId((int)$this->db->lastInsertId());
             $this->cache->set($user->getId(), $user);
             $this->cache->delete('all');
         }
    }

    public function update(User $user)
    {
        $query = 'UPDATE users SET email = :email, currency  = :currency, sum = :sum, 
          firstname = :firstname, lastname  = :lastname, patronymic = :patronymic WHERE id = :id';

        $result = $this->db->prepare($query)->execute([':email' => $user->getEmail(), ':currency'  => $user->getCurrency(),
            ':sum' => $user->getSum(), ':firstname' => $user->getFirstname(), ':lastname' => $user->getLastname(),
            ':patronymic' => $user->getPatronymic(), ':id' => $user->getId()]);
        if($result && $this->cache){
            $this->cache->set($user->getId(), $user);
            $this->cache->delete('all');
        }
    }

    public function delete(int $userId)
    {

        $result = $this->db->prepare('DELETE FROM users WHERE id = :id')->execute([':id' => $userId]);
        if($result && $this->cache){
            $this->cache->delete($userId);
            $this->cache->delete('all');
        }
    }

}