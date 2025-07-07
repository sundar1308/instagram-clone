<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%likes}}`.
 */
class m241105_122649_create_likes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%likes}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-likes-post_id',
            '{{%likes}}',
            'post_id',
            '{{%posts}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-likes-user_id',
            '{{%likes}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-likes-post_id', '{{%likes}}');
        $this->dropForeignKey('fk-likes-user_id', '{{%likes}}');
        $this->dropTable('{{%likes}}');
    }
}
