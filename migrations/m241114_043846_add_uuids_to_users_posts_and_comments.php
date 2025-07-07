<?php

use yii\db\Migration;

/**
 * Class m241114_043846_add_uuids_to_users_posts_and_comments
 */
class m241114_043846_add_uuids_to_users_posts_and_comments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add uuid column to users table if it doesn't exist, and set it to unique
        if (!$this->db->getTableSchema('user', true)->getColumn('uuid')) {
            $this->addColumn('user', 'uuid', $this->string(36)->notNull()->unique()->after('id'));
        }

        // Add uuid column to posts table if it doesn't exist, and set it to unique
        if (!$this->db->getTableSchema('posts', true)->getColumn('uuid')) {
            $this->addColumn('posts', 'uuid', $this->string(36)->notNull()->unique()->after('id'));
        }

        // Add uuid column to comments table if it doesn't exist, and set it to unique
        if (!$this->db->getTableSchema('comments', true)->getColumn('uuid')) {
            $this->addColumn('comments', 'uuid', $this->string(36)->notNull()->unique()->after('id'));
        }

        // Add user_uuid to posts table if it doesn't exist
        if (!$this->db->getTableSchema('posts', true)->getColumn('user_uuid')) {
            $this->addColumn('posts', 'user_uuid', $this->string(36)->notNull()->defaultValue(null)->after('id'));
        }

        // Add foreign key for user_uuid in posts table referencing users table
        $this->addForeignKey(
            'fk-posts-user_uuid', 
            'posts', 
            'user_uuid', 
            'user', 
            'uuid', 
            'CASCADE'
        );

        // Add post_uuid and user_uuid to comments table if they do not exist
        if (!$this->db->getTableSchema('comments', true)->getColumn('post_uuid')) {
            $this->addColumn('comments', 'post_uuid', $this->string(36)->notNull()->after('id'));
        }

        if (!$this->db->getTableSchema('comments', true)->getColumn('user_uuid')) {
            $this->addColumn('comments', 'user_uuid', $this->string(36)->notNull()->after('post_uuid'));
        }

        // Add foreign keys for post_uuid and user_uuid in comments table
        $this->addForeignKey(
            'fk-comments-post_uuid', 
            'comments', 
            'post_uuid', 
            'posts', 
            'uuid', 
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-comments-user_uuid', 
            'comments', 
            'user_uuid', 
            'user', 
            'uuid', 
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys and columns in case of rollback

        // Drop foreign key and column for posts
        $this->dropForeignKey('fk-posts-user_uuid', 'posts');
        $this->dropColumn('posts', 'user_uuid');
        $this->dropColumn('posts', 'uuid');

        // Drop foreign keys and columns for comments
        $this->dropForeignKey('fk-comments-post_uuid', 'comments');
        $this->dropForeignKey('fk-comments-user_uuid', 'comments');
        $this->dropColumn('comments', 'post_uuid');
        $this->dropColumn('comments', 'user_uuid');
        $this->dropColumn('comments', 'uuid');

        // Drop uuid column for users
        $this->dropColumn('user', 'uuid');
    }
}
