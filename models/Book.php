<?php

namespace app\models;

use app\models\base\Book as BookBase;

/**
 * Class Book
 *
 * @property Reserve $reservation
 * @property string $reserveOrder
 * @package app\models
 */
class Book extends BookBase
{
    /**
     * Может ли пользователь зарезервировать книгу
     *
     * @return bool
     */
    public function canReserve()
    {
        return $this->canSubmit() || $this->isReserved() || $this->isAvailable() ? false : true;
    }

    /**
     * Может ли пользователь взять книгу
     *
     * @return bool
     */
    public function isAvailable()
    {
        $takeReservation = $this->getReserves()->andWhere(['status' => Reserve::UNAVAILABLE])->one();
        if($takeReservation === null) {
            $priorityReservation = $this->getReserves()
                ->andWhere(['status' => Reserve::RESERVED])
                ->orderBy(['updated_at' => SORT_ASC])
                ->one();
            if($priorityReservation === null) {
                return true;
            }
            elseif($priorityReservation->user_id == \Yii::$app->user->identity->getId()) {
                    return true;
            }
        }

        return false;
    }

    /**
     * Может ли пользователь сдать книгу
     *
     * @return bool
     */
    public function canSubmit()
    {
        return $this->reservation && $this->reservation->status == Reserve::UNAVAILABLE ? true : false;
    }

    /**
     * Может ли пользователь отменить резервирвание
     *
     * @return bool
     */
    public function isReserved()
    {
        return $this->reservation && $this->reservation->status == Reserve::RESERVED ? true : false;
    }

    /**
     * Запись статуса резерва по книге текущего пользователя
     *
     * @return array|\yii\db\ActiveRecord|null
     */
    public function getReservation()
    {
        return $this->getReserves()->andWhere(['user_id' => \Yii::$app->user->identity->getId()])->one();
    }

    /**
     * Получение очереди резервирования для книги
     *
     * @return array
     */
    public function getReserveOrder()
    {
        $reservations = $this->getReserves()
            ->andWhere(['status' => Reserve::RESERVED])
            ->orderBy(['updated_at' => SORT_ASC])
            ->all();

        $reserveOrder = [];
        foreach($reservations as $key => $reservation) {
            $reserveOrder[] = 1 + $key.'. '.$reservation->user->username;
        }

        return $reserveOrder;
    }
}