<?php

namespace common\dto;

use yii\base\Model;

class UpdateUserDto extends Model
{
    public ?string $username = null;
    public ?string $email = null;
    public ?string $date_of_birth = null;
    public ?string $passport_number = null;
    public ?string $passport_expiry_date = null;

    public function rules()
    {
        return [
            [['username', 'email', 'date_of_birth', 'passport_number', 'passport_expiry_date'], 'safe'],
            [['username', 'email'], 'string', 'max' => 255],
            ['email', 'email'],
            ['date_of_birth', 'date', 'format' => 'php:Y-m-d'],
            ['passport_expiry_date', 'date', 'format' => 'php:Y-m-d'],
        ];
    }
}
