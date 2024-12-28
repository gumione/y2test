<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%refresh_tokens}}`.
 */
class m241228_023621_create_refresh_tokens_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%refresh_tokens}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'token' => $this->string(512)->notNull()->unique(),
            'expires_at' => $this->timestamp()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-refresh_tokens-user_id', '{{%refresh_tokens}}', 'user_id');
        $this->addForeignKey(
            'fk-refresh_tokens-user_id',
            '{{%refresh_tokens}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-refresh_tokens-user_id', '{{%refresh_tokens}}');
        $this->dropIndex('idx-refresh_tokens-user_id', '{{%refresh_tokens}}');
        $this->dropTable('{{%refresh_tokens}}');
    }
}
