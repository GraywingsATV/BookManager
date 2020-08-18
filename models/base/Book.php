<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $id
 * @property string $title Название книги
 *
 * @property Reserve[] $reserves
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название книги',
        ];
    }

    /**
     * Gets query for [[Reserves]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReserves()
    {
        return $this->hasMany(Reserve::className(), ['book_id' => 'id']);
    }
}
