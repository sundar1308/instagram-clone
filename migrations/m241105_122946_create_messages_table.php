<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%messages}}`.
 */
class m241105_122946_create_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%messages}}', [
            'id' => $this->primaryKey(),
            'sender_id' => $this->integer()->notNull(),
            'receiver_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'read_at' => $this->timestamp()->null(),
        ]);

        $this->addForeignKey(
            'fk-messages-sender_id',
            '{{%messages}}',
            'sender_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-messages-receiver_id',
            '{{%messages}}',
            'receiver_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-messages-sender_id', '{{%messages}}');
        $this->dropForeignKey('fk-messages-receiver_id', '{{%messages}}');
        $this->dropTable('{{%messages}}');
    }
}
