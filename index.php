<?php

namespace App;

require_once __DIR__.'/vendor/autoload.php';

use App\Controller\UserController;
use App\Db\PdoMysqlConnection;
use App\Repository\UserRepository;


$pdo = new PdoMysqlConnection();
$pdo->connect();
$client = new UserRepository($pdo);
//$client->save($user);
//var_dump($client->find(22));
//var_dump($client->findBy(['firstname' => 'T'],['id' => 'ASC'],2,1));
$controller = new UserController($client);

switch (strtok($_SERVER['REQUEST_URI'],'?')){
    case '/':
        $controller->indexAction();
        break;
    case '/create':
        $controller->createAction($_REQUEST);
        break;
    case '/edit':
        $controller->editAction($_REQUEST);
        break;
    case '/update':
        $controller->updateAction($_REQUEST);
        break;
    case '/delete':
        $controller->deleteAction($_REQUEST);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}
//foreach($client->find(1) as $key => $user){
//    $user->setFirstname($user->getFirstname().$key);
//    $client->update($user);
//    $client->delete($user);
//}