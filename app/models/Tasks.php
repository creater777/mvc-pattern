<?php
namespace App\models;

use Lib\BaseModel;

/**
 * @property int id
 * @property int title
 * @property int task
 * @property int userId
 * @property bool ready
 */
class Tasks extends BaseModel
{
    private static $users = [];

    public const labels = [
        'id' => '#',
        'title' => 'Заголовок',
        'task' => 'Описание задачи',
        'user' => 'Пользователь',
        'userEmail' => 'email',
        'visualReady' => 'Статус',
    ];

    /**
     * @return Users
     */
    public function getUser(){
        if (self::$users[$this->userId] === null){
            self::$users[$this->userId] = Users::find($this->userId);
        }
        return self::$users[$this->userId];
    }

    public function getUserEMail(){
        return Users::find($this->userId)->email;
    }

    public function getVisualReady(){
        return $this->ready ? 'Выполненно' : 'Не выполненно';
    }
}