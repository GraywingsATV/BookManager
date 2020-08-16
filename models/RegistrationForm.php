<?php

namespace app\models;

use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $password;
    public $repeatPassword;

    public function rules()
    {
        return [
            [['username', 'password', 'repeatPassword'], 'required'],
            ['password', 'comparePasswords'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'repeatPassword' => 'Пароль(повторно)'
        ];
    }

    /**
     * Проверяем совпадают ли пароль и повторный пароль
     *
     * @param $attribute
     * @param $params
     */
    public function comparePasswords($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if ($this->password !== $this->repeatPassword) {
                $message = 'Введенные пароли не совпадают';
                $this->addError($attribute, $message);
                $this->addError('repeatPassword', $message);
            }
        }
    }

    /**
     * Регистрируем нового пользователя
     *
     * @return bool
     */
    public function register()
    {
        if(!$this->validate()) return false;

        $user = new User();
        $user->password = $this->password;
        $user->username = $this->username;
        return $user->save();
    }
}