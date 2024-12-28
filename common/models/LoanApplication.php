<?php

namespace common\models;

use yii\db\ActiveRecord;

class LoanApplication extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%loan_application}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'loan_amount', 'loan_term', 'monthly_income'], 'required'],
            [['user_id', 'loan_amount', 'loan_term', 'monthly_income', 'outstanding_balance'], 'integer'],
            [['loan_amount', 'monthly_income'], 'compare', 'compareValue' => 0, 'operator' => '>'],
            ['loan_term', 'in', 'range' => range(6, 60)],
            ['loan_purpose', 'string'],
            ['status', 'validateStatus'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getApplicationStatus()
    {
        return $this->hasOne(LoanApplicationStatus::class, ['id' => 'status']);
    }
    
    public function validateStatus($attribute, $params, $validator)
    {
        $repository = \Yii::$container->get(\common\repositories\interfaces\LoanApplicationStatusRepositoryInterface::class);

        if (!$repository->existsById($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'The selected status does not exist.'));
        }
    }

}
