<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reserve`.
 */
class m200816_181217_Create_reserve_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reserve', [
            'id' => $this->primaryKey(),
            'book_id' => $this->integer()->comment('Книга'),
            'user_id' => $this->integer()->comment('Пользователь'),
            'status' => $this->integer(1)->comment('Статус'),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('book_id', 'reserve', 'book_id', 'book', 'id', 'CASCADE');
        $this->addForeignKey('user_id', 'reserve', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('reserve');
    }
}
