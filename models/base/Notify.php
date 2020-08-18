<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "notify".
 *
 * @property int $id
 * @property int $user_id Пользователь
 * @property string $message Сообщение
 * @property int $status Статус
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 */
class Notify extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notify';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'message', 'status'], 'required'],
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'message' => 'Сообщение',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
