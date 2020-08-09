<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Intl\Currencies;
use Exception;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function indexAction(){

        $this->view(__DIR__.'/../Views/index.php', ['users' => $this->repository->findBy([],['id' => 'DESC']),
            'currencies' => Currencies::getNames()]);
    }

    public function createAction($request){

        $user = new User();
        $user->handleRequest($request);
        $this->repository->save($user);
        header('Location: /');
    }

    public function editAction($request){

        if(isset($_GET['id'])) {
            $this->view(__DIR__ . '/../Views/edit.php', ['user' => $this->repository->find($_GET['id']),
                'currencies' => Currencies::getNames()]);
        }
        else {
            header("HTTP/1.0 404 Not Found");
        }
    }

    public function updateAction($request){

        $user = new User();
        $user->handleRequest($request);
        $this->repository->update($user);
        header('Location: /edit?id='.$user->getId());
    }

    public function deleteAction($request){

        if(isset($_GET['id'])) {
            $this->repository->delete($_GET['id']);
        }
        header('Location: /');
    }

}