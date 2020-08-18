<?php

namespace app\models;

use app\models\base\Notify as NotifyBase;
use yii\behaviors\TimestampBehavior;

class Notify extends NotifyBase
{
    const STATUS_NEW = 1;
    const STATUS_VIEWED = 2;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * Отправка уведомления о возврате книги
     *
     * @param $book_id
     */
    public static function nextReservedUser($book_id)
    {
        $priority_reserve = Reserve::find()
            ->where(['book_id' => $book_id])
            ->andWhere(['status' => Reserve::RESERVED])
            ->orderBy(['updated_at' => SORT_ASC])
            ->one();

        if($priority_reserve) {
            $notify = new Notify();
            $notify->user_id = $priority_reserve->user_id;
            $notify->status = Notify::STATUS_NEW;
            $notify->message = 'Книга "'.$priority_reserve->book->title.'" доступна в библиотеке.';
            $notify->save();
        }
    }

    /**
     * Отметка о просмотре уведомления
     */
    public function view()
    {
        $this->status = self::STATUS_VIEWED;
        $this->save();
    }
}