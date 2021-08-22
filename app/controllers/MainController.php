<?php
namespace App\controllers;

use App\models\Tasks;
use App\models\Users;
use Lib\App;

class MainController {

    /**
     * @param int $from
     * @param int $to
     * @param string $field
     * @param string $order
     * @return array
     * @throws \Exception
     */
    public function index($from=0, $to=3, $field='id', $order=null){
        $order = $order === null ? "" : "DESC";
        return [
            'view' => "index",
            'model' => Tasks::getFromTo($from, $to, $field, $order)
        ];
    }

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