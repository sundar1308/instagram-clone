<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notifications}}`.
 */
class m241105_123027_create_notifications_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notifications}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'type' => $this->string()->notNull(), // e.g., like, comment, follow
            'post_id' => $this->integer()->null(),
            'sender_id' => $this->integer()->null(),
            'message' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'read_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk-notifications-user_id',
            '{{%notifications}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-notifications-post_id',
            '{{%notifications}}',
            'post_id',
            '{{%posts}}',
            'id',
            'SET NULL',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-notifications-sender_id',
            '{{%notifications}}',
            'sender_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-notifications-user_id', '{{%notifications}}');
        $this->dropForeignKey('fk-notifications-post_id', '{{%notifications}}');
        $this->dropForeignKey('fk-notifications-sender_id', '{{%notifications}}');
        $this->dropTable('{{%notifications}}');
    }
}
