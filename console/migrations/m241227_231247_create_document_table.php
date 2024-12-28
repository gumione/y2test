<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document}}`.
 */
class m241227_231247_create_document_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%document}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'document_type_id' => $this->integer()->notNull(),
            'file_path' => $this->string()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-document-user_id',
            '{{%document}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-document-document_type_id',
            '{{%document}}',
            'document_type_id',
            '{{%document_type}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-document-user_id', '{{%document}}');
        $this->dropForeignKey('fk-document-document_type_id', '{{%document}}');
        $this->dropTable('{{%document}}');
    }
}
