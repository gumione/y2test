<?php

use yii\db\Migration;

/**
 * Class m241227_232323_loan_application_status_table
 */
class m241227_232323_loan_application_status_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%loan_application_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%loan_application_status}}');
    }
}
