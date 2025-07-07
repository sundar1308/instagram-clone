<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment_likes}}`.
 */
class m241108_100316_create_comment_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Create the comment_likes table
        $this->createTable('comment_likes', [
            'id' => $this->primaryKey(), // Primary key
            'comment_id' => $this->integer()->notNull(), // Foreign key to the comments table
            'user_id' => $this->integer()->notNull(), // Foreign key to the users table
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'), // Timestamp for when the like was created
        ]);

        // Add foreign key for comment_id referencing the comments table
        $this->addForeignKey(
            'fk_comment_likes_comment_id',
            'comment_likes',
            'comment_id',
            'comments', // Assumed that the comments table is called 'comments'
            'id',
            'CASCADE'
        );

        // Add foreign key for user_id referencing the user table
        $this->addForeignKey(
            'fk_comment_likes_user_id',
            'comment_likes',
            'user_id',
            'user', // Assumed that the user table is called 'user'
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys
        $this->dropForeignKey('fk_comment_likes_comment_id', 'comment_likes');
        $this->dropForeignKey('fk_comment_likes_user_id', 'comment_likes');

        // Drop the table
        $this->dropTable('comment_likes');
    }
}
