<?php

namespace common\services\interfaces;

use common\models\User;
use common\dto\RegisterDto;
use common\dto\LoginDto;

interface AuthServiceInterface
{
    public function register(RegisterDto $dto): ?User;

    public function login(LoginDto $dto): ?array;
}
