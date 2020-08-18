<?php

namespace app\models;

use app\models\base\Reserve as ReserveBase;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Reserve extends ReserveBase
{
    const RESERVED = 1;
    const SUBMITTED = 2;
    const UNAVAILABLE = 3;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
}