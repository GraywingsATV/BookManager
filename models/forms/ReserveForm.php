<?php

namespace app\models\forms;

use yii\base\Model;

class ReserveForm extends Model
{
    public $user;
    public $book;

    public function attributeLabels()
    {
        return [
            'user' => 'Пользователь',
            'book' => 'Книга',
        ];
    }

    public function rules()
    {
        return [
            [['user', 'book'], 'integer']
        ];
    }
}