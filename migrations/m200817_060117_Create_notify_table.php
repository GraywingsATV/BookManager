<?php

use yii\db\Migration;

/**
 * Handles the creation of table `notify`.
 */
class m200817_060117_Create_notify_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('notify', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'message' => $this->text()->notNull()->comment('Сообщение'),
            'status' => $this->integer(1)->notNull()->comment('Статус'),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('notify_user_id', 'notify', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('notify_user_id', 'notify');
        $this->dropTable('notify');
    }
}
