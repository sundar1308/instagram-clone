<?php

use yii\db\Migration;

/**
 * Class m241114_063646_add_user_uuid_and_post_uuid_to_likes
 */
class m241114_063646_add_user_uuid_and_post_uuid_to_likes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add 'user_uuid' and 'post_uuid' columns to the 'likes' table
        $this->addColumn('likes', 'user_uuid', $this->string(36)->notNull());
        $this->addColumn('likes', 'post_uuid', $this->string(36)->notNull());

        // Add foreign key for user_uuid
        $this->addForeignKey(
            'fk-likes-user_uuid',   // Foreign key name
            'likes',                 // The table containing the foreign key
            'user_uuid',             // The column in 'likes' that will be the foreign key
            'user',                  // The referenced table
            'uuid',                  // The column in 'user' that 'user_uuid' references
            'CASCADE',               // What happens when the referenced row is deleted
            'CASCADE'               // What happens when the referenced row is updated
        );

        // Add foreign key for post_uuid
        $this->addForeignKey(
            'fk-likes-post_uuid',   // Foreign key name
            'likes',                // The table containing the foreign key
            'post_uuid',            // The column in 'likes' that will be the foreign key
            'posts',                // The referenced table
            'uuid',                 // The column in 'posts' that 'post_uuid' references
            'CASCADE',              // What happens when the referenced row is deleted
            'CASCADE'               // What happens when the referenced row is updated
        );
        
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop foreign key and index if the migration is rolled back

        // Drop the foreign key for 'user_uuid'
        $this->dropForeignKey('fk-likes-user_uuid', 'likes');

        // Drop the foreign key for 'post_uuid'
        $this->dropForeignKey('fk-likes-post_uuid', 'likes');

        // Drop the unique composite index
        $this->dropIndex('idx-likes-user_uuid-post_uuid', 'likes');

        // Drop the columns
        $this->dropColumn('likes', 'user_uuid');
        $this->dropColumn('likes', 'post_uuid');
    }
}
