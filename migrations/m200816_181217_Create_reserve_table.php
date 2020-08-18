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
            'book_id' => $this->integer()->notNull()->comment('Книга'),
            'user_id' => $this->integer()->notNull()->comment('Пользователь'),
            'status' => $this->integer(1)->notNull()->comment('Статус'),
            'updated_at' => $this->integer(),
        ]);

        $this->addForeignKey('reserve_book_id', 'reserve', 'book_id', 'book', 'id', 'CASCADE');
        $this->addForeignKey('reserve_user_id', 'reserve', 'user_id', 'user', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('reserve_book_id', 'reserve');
        $this->dropForeignKey('reserve_user_id', 'reserve');
        $this->dropTable('reserve');
    }
}
