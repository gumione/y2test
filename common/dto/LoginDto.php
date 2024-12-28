<?php

namespace common\dto;

use Yii;

class LoginDto
{
    public string $email;
    public string $password;

    public function __construct(array $data)
    {
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
    }

    public function validate(): bool
    {
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false &&
               strlen($this->password) >= 6;
    }

    public function getErrors(): array
    {
        $errors = [];
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = Yii::t('app', 'Invalid email format');
        }
        if (strlen($this->password) < 6) {
            $errors['password'] = Yii::t('app', 'Password must be at least 6 characters');
        }
        return $errors;
    }
}
