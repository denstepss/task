<?php


namespace App\Tests;

require_once 'config.php';

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    /**
     * @dataProvider providerField
     */
    public function testFieldSet(array $data)
    {
        $user = new User();
        $user->setFirstname($data['firstname']);
        $user->setLastname($data['lastname']);
        $user->setPatronymic($data['patronymic']);
        $user->setCurrency($data['currency']);
        $user->setEmail($data['email']);
        $user->setSum($data['sum']);

        $user2 = new User();
        $user2->handleRequest($data);

        $this->assertEquals($user, $user2);
        $this->assertNotSame($user, $user2);

    }

    public function testWrongRequest()
    {
        $this->expectError();
        $user = new User();
        $user->handleRequest(['notCorrectRequest'=>'data']);
        print get_object_vars($user);


    }

    public function providerField ()
    {
        return [
            [['firstname' => 'Check', 'lastname'=> 'Chelovek', 'patronymic' => 'Chelovekov','currency' => 'USD', 'email' => 'test@gmail.com', 'sum' => '11.1']],
            [['firstname' => 'Check2', 'lastname'=> 'Chelovek2', 'patronymic' => 'Chelovekov2','currency' => 'USD', 'email' => 'test2@gmail.com', 'sum' => '12.2']],
            [['firstname' => 'Check3', 'lastname'=> 'Chelovek3', 'patronymic' => 'Chelovekov3','currency' => 'USD', 'email' => 'test3@gmail.com', 'sum' => '13.3']],
        ];
    }

}