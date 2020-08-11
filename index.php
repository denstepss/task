<?php

namespace App;

require_once __DIR__.'/vendor/autoload.php';
include_once 'config.php';

use App\Controller\UserController;
use App\Db\PdoMysqlConnection;
use App\Repository\UserRepository;


$pdo = new PdoMysqlConnection();
$pdo->connect();
$client = new UserRepository($pdo);
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
    case '/strict_search':
        $controller->searchAction($_REQUEST);
        break;
    case '/search_like':
        $controller->searchLikeAction($_REQUEST);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        break;
}
