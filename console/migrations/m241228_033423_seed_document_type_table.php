<?php

use yii\db\Migration;

/**
 * Class m241228_033423_seed_document_type_table
 */
class m241228_033423_seed_document_type_table extends Migration
{
    public function up()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%document_type}}', ['id', 'name'], [
            [1, 'Passport'],
            [2, 'Document 1'],
            [3, 'Document 2'],
        ])->execute();
    }

    public function down()
    {
        Yii::$app->db->createCommand()->delete('{{%document_type}}')->execute();
    }
}
