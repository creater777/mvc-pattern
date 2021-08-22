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
        App::goHome();
    }

    public function logout(){
        App::logout();
        App::goHome();
    }
}