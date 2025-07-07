<?php

use yii\db\Migration;

/**
 * Class m241108_083406_add_parent_comment_id_to_comments_table
 */
class m241108_083406_add_parent_comment_id_to_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Add the parent_comment_id column (nullable INT)
        $this->addColumn('comments', 'parent_comment_id', $this->integer()->null());

        // Add foreign key constraint (if you want to enforce the relationship with the same table)
        $this->addForeignKey(
            'fk_comments_parent_comment',   // Foreign key name
            'comments',                      // The table containing the foreign key
            'parent_comment_id',             // The column containing the foreign key
            'comments',                      // The referenced table (same table in this case)
            'id',                            // The column that the foreign key points to
            'CASCADE'                        // Action on delete
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop the foreign key constraint
        $this->dropForeignKey('fk_comments_parent_comment', 'comments');

        // Drop the parent_comment_id column
        $this->dropColumn('comments', 'parent_comment_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241108_083406_add_parent_comment_id_to_comments_table cannot be reverted.\n";

        return false;
    }
    */
}
