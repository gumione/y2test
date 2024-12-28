<?php

namespace common\models;

use yii\db\ActiveRecord;

class LoanApplicationStatus extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%loan_application_status}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            ['name', 'string', 'max' => 50],
        ];
    }
}
