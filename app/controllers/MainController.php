<?php
namespace App\controllers;

use App\models\Tasks;
use App\models\Users;
use Lib\App;

class MainController {

    const PAGE_SIZE = 3;

    /**
     * @param int $page
     * @param string $field
     * @param string $order
     * @return array
     * @throws \Exception
     */
    public function index($page=0, $field='id', $order=null){
        $order = $order === null ? "" : "DESC";
        return [
            'view' => "index",
            'model' => Tasks::getFromTo($page * self::PAGE_SIZE, self::PAGE_SIZE, $field, $order),
            'pagination' => [
                'page' => $page,
                'pages' => ceil(Tasks::count()/self::PAGE_SIZE)
            ]
        ];
    }

    /**
     * @param $name
     * @param $password
     * @throws \Exception
     */
    public function login($name, $password){
        $user = Users::findByName($name);
        if (!empty($user) && $user->verify($password)) {
            App::login($user);
        } else {
            App::pushError("Не верен логин или пароль");
        };
        App::goBack();
    }

    public function logout(){
        App::logout();
        App::goBack();
    }

    /**
     * @param $id
     * @param $title
     * @param $task
     * @param int $ready
     * @throws \Exception
     */
    public function change($id, $title, $task, $ready = 0){
        $t = Tasks::find($id);
        if ($t !== null && App::userIsLogged()){
            $t->title = $title;
            $t->task = $task;
            $t->ready = $ready;
            $t->store();
        }
        App::goBack();
    }

    /**
     * @param $title
     * @param $task
     * @param int $ready
     * @throws \RedBeanPHP\RedException\SQL
     * @throws \Exception
     */
    public function add($title, $task, $ready = 0) {
        $t = new Tasks();
        $t->title = $title;
        $t->task = $task;
        $t->ready = $ready;
        $t->userId = App::userIsLogged() ? App::$user->id : 0;
        $t->store();
        App::goBack();
    }
}