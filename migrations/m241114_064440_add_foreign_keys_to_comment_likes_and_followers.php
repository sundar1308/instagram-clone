<?php

use yii\db\Migration;

/**
 * Class m241114_064440_add_foreign_keys_to_comment_likes_and_followers
 */
class m241114_064440_add_foreign_keys_to_comment_likes_and_followers extends Migration
{
    public function safeUp()
    {
        // Add 'comment_uuid' and 'user_uuid' columns to the 'comment_likes' table
        $this->addColumn('comment_likes', 'comment_uuid', $this->string(36)->notNull());
        $this->addColumn('comment_likes', 'user_uuid', $this->string(36)->notNull());

        // Add foreign key for comment_uuid
        $this->addForeignKey(
            'fk-comment_likes-comment_uuid', // Foreign key name
            'comment_likes',                  // The table containing the foreign key
            'comment_uuid',                   // The column in 'comment_likes' that will be the foreign key
            'comments',                       // The referenced table
            'uuid',                           // The column in 'comments' that 'comment_uuid' references
            'CASCADE',                        // What happens when the referenced row is deleted
            'CASCADE'                         // What happens when the referenced row is updated
        );

        // Add foreign key for user_uuid
        $this->addForeignKey(
            'fk-comment_likes-user_uuid',    // Foreign key name
            'comment_likes',                  // The table containing the foreign key
            'user_uuid',                      // The column in 'comment_likes' that will be the foreign key
            'user',                           // The referenced table
            'uuid',                           // The column in 'user' that 'user_uuid' references
            'CASCADE',                        // What happens when the referenced row is deleted
            'CASCADE'                         // What happens when the referenced row is updated
        );

        // Add 'user_uuid' and 'follower_uuid' columns to the 'followers' table
        $this->addColumn('followers', 'user_uuid', $this->string(36)->notNull());
        $this->addColumn('followers', 'follower_uuid', $this->string(36)->notNull());

        // Add foreign key for user_uuid in followers table
        $this->addForeignKey(
            'fk-followers-user_uuid',         // Foreign key name
            'followers',                      // The table containing the foreign key
            'user_uuid',                      // The column in 'followers' that will be the foreign key
            'user',                           // The referenced table
            'uuid',                           // The column in 'user' that 'user_uuid' references
            'CASCADE',                        // What happens when the referenced row is deleted
            'CASCADE'                         // What happens when the referenced row is updated
        );

        // Add foreign key for follower_uuid in followers table
        $this->addForeignKey(
            'fk-followers-follower_uuid',     // Foreign key name
            'followers',                      // The table containing the foreign key
            'follower_uuid',                  // The column in 'followers' that will be the foreign key
            'user',                           // The referenced table
            'uuid',                           // The column in 'user' that 'follower_uuid' references
            'CASCADE',                        // What happens when the referenced row is deleted
            'CASCADE'                         // What happens when the referenced row is updated
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign keys and indexes in reverse order
        $this->dropForeignKey('fk-comment_likes-comment_uuid', 'comment_likes');
        $this->dropForeignKey('fk-comment_likes-user_uuid', 'comment_likes');
        $this->dropForeignKey('fk-followers-user_uuid', 'followers');
        $this->dropForeignKey('fk-followers-follower_uuid', 'followers');

        // Drop the columns added
        $this->dropColumn('comment_likes', 'comment_uuid');
        $this->dropColumn('comment_likes', 'user_uuid');
        $this->dropColumn('followers', 'user_uuid');
        $this->dropColumn('followers', 'follower_uuid');
    }
}
