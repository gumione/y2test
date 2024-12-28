<?php

use yii\db\Migration;

/**
 * Class m241227_231301_loan_application_table
 */
class m241227_231301_loan_application_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%loan_application}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'loan_amount' => $this->integer()->notNull(),
            'loan_term' => $this->integer()->notNull(),
            'loan_purpose' => $this->text(),
            'monthly_income' => $this->integer()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('pending'),
            'outstanding_balance' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->addForeignKey(
            'fk-loan_application-user_id',
            '{{%loan_application}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-loan_application-user_id', '{{%loan_application}}');
        $this->dropTable('{{%loan_application}}');
    }
}
