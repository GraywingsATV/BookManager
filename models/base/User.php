<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username Логин
 * @property string $auth_key
 * @property string $password_hash
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property Notify[] $notifies
 * @property Reserve[] $reserves
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Notifies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotifies()
    {
        return $this->hasMany(Notify::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reserves]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['user_id' => 'id']);
    }
}
