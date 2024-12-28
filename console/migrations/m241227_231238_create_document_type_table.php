<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%document_type}}`.
 */
class m241227_231238_create_document_type_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%document_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text()->null(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%document_type}}');
    }
}
