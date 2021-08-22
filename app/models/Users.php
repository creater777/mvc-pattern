<?php
namespace App\models;

use Lib\BaseModel;
use Lib\App;

/**
 * @property Users name
 * @property string email
 * @property string password
 */
class Users extends BaseModel {

    /**
     * @param $userName
     * @return Users|\RedBeanPHP\OODBBean
     * @throws \Exception
     */
    public static function findByName($userName){
        $bean = App::getDBInstance()::findOne('users', 'name=:name', ['name' => $userName]);
        $user = new Users($bean);
        return $user;
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->name;
    }

    /**
     * @param $password
     * @return bool
     */
    public function verify($password){
        return password_verify($this->name.$password.$this->email, $this->password);
    }

    /**
     * @param $password
     */
    public function setPassword($password){
        $this->password = password_hash($this->name.$password.$this->email, PASSWORD_BCRYPT);
    }
}