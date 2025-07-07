<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%conversations}}`.
 */
class m241118_112044_create_conversations_table extends Migration
{
    
    
    public function safeUp()
    {
        // Create the `conversations` table
        $this->createTable('conversations', [
            'id' => $this->primaryKey(),
            'user1_id' => $this->integer()->notNull(),
            'user2_id' => $this->integer()->notNull(),
            'last_message_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Create indexes for foreign key columns
        $this->createIndex('idx_conversations_user1', 'conversations', 'user1_id');
        $this->createIndex('idx_conversations_user2', 'conversations', 'user2_id');
        $this->createIndex('idx_conversations_last_message', 'conversations', 'last_message_id');

        // Add foreign key constraints
        $this->addForeignKey(
            'fk_conversations_user1', 
            'conversations', 
            'user1_id', 
            'user', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_conversations_user2', 
            'conversations', 
            'user2_id', 
            'user', 
            'id', 
            'CASCADE', 
            'CASCADE'
        );

        $this->addForeignKey(
            'fk_conversations_last_message', 
            'conversations', 
            'last_message_id', 
            'messages', 
            'id', 
            'SET NULL', 
            'CASCADE'
        );
    }

    public function safeDown()
    {
        // Drop foreign key constraints
        $this->dropForeignKey('fk_conversations_user1', 'conversations');
        $this->dropForeignKey('fk_conversations_user2', 'conversations');
        $this->dropForeignKey('fk_conversations_last_message', 'conversations');

        // Drop the `conversations` table
        $this->dropTable('conversations');
    }

}
