<?php

namespace common\services\interfaces;

use common\models\User;
use common\dto\UpdateUserDto;

interface UserServiceInterface
{
    public function updateUser(User $user, UpdateUserDto $dto): bool;
}
