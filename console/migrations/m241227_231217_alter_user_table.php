<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m241227_231217_alter_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'first_name', $this->string()->after('email'));
        $this->addColumn('{{%user}}', 'last_name', $this->string()->after('first_name'));
        $this->addColumn('{{%user}}', 'date_of_birth', $this->date()->after('last_name'));
        $this->addColumn('{{%user}}', 'passport_number', $this->string()->after('date_of_birth'));
        $this->addColumn('{{%user}}', 'passport_expiry_date', $this->date()->after('passport_number'));
        
        $this->alterColumn('{{%user}}', 'created_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'));
        $this->alterColumn('{{%user}}', 'updated_at', $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'first_name');
        $this->dropColumn('{{%user}}', 'last_name');
        $this->dropColumn('{{%user}}', 'date_of_birth');
        $this->dropColumn('{{%user}}', 'passport_number');
        $this->dropColumn('{{%user}}', 'passport_expiry_date');
        
        $this->alterColumn('{{%user}}', 'created_at', $this->integer()->notNull());
        $this->alterColumn('{{%user}}', 'updated_at', $this->integer()->notNull());
    }
}
