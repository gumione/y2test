<?php

use yii\db\Migration;

/**
 * Class m241227_232646_seed_loan_application_status_table
 */
class m241227_232646_seed_loan_application_status_table extends Migration
{
    public function up()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%loan_application_status}}', ['id', 'name'], [
            [1, 'Pending'],
            [2, 'Approved'],
            [3, 'Rejected'],
        ])->execute();
    }

    public function down()
    {
        Yii::$app->db->createCommand()->delete('{{%loan_application_status}}')->execute();
    }
}
