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
        return Users::find($this->userId);
    }

    public function getUserEMail(){
        return Users::find($this->userId)->email;
    }

    public function getVisualReady(){
        return $this->ready ? 'Выполненно' : 'Не выполненно';
    }
}