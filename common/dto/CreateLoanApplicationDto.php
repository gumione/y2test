<?php

namespace common\dto;

use yii\base\Model;

class CreateLoanApplicationDto extends Model
{
    public int $loan_amount;
    public int $loan_term;
    public string $loan_purpose;
    public int $monthly_income;

    public function rules()
    {
        return [
            [['loan_amount', 'loan_term', 'monthly_income'], 'integer', 'min' => 1],
            ['loan_term', 'integer', 'min' => 6, 'max' => 60],
            ['loan_purpose', 'string', 'max' => 255],
            [['loan_amount', 'loan_term', 'loan_purpose', 'monthly_income'], 'required'],
        ];
    }
}
