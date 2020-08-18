<?php

namespace app\models\forms;

use app\models\User;
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
            ['username', 'checkIfUserExists']
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
                $message = 'Введенные пароли не совпадают.';
                $this->addError($attribute, $message);
                $this->addError('repeatPassword', $message);
            }
        }
    }

    /**
     * Проверяем существует ли такой пользователь
     *
     * @param $attribute
     * @param $params
     */
    public function checkIfUserExists($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (User::findByUsername($this->username)) {
                $message = 'Этот логин занят используйте другой.';
                $this->addError($attribute, $message);
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
        if($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->password = $this->password;
            if($user->save()) return true;

            \Yii::$app->session->setFlash('error', 'Возникла ошибка при регистрации нового пользователя.');
        }

        return false;
    }
}