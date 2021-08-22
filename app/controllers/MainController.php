<?php
namespace App\controllers;

use App\models\Tasks;
use App\models\Users;
use Lib\App;

class MainController {

    public function index($from=0, $to=3){
        return [
            'view' => "index",
            'model' => Tasks::getFromTo($from, $to)
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
}