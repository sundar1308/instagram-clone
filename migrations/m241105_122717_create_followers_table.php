<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%followers}}`.
 */
class m241105_122717_create_followers_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%followers}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'follower_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-followers-user_id',
            '{{%followers}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-followers-follower_id',
            '{{%followers}}',
            'follower_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-followers-user_id', '{{%followers}}');
        $this->dropForeignKey('fk-followers-follower_id', '{{%followers}}');
        $this->dropTable('{{%followers}}');
    }
}
