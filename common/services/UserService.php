<?php

namespace common\services;

use common\models\User;
use common\dto\UpdateUserDto;
use common\services\interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function updateUser(User $user, UpdateUserDto $dto): bool
    {
        if (!$dto->validate()) {
            throw new \DomainException('Invalid data: ' . json_encode($dto->getErrors()));
        }

        $user->setAttributes($dto->getAttributes(), false);

        if (!$user->save()) {
            throw new \RuntimeException('Failed to update user data.');
        }

        return true;
    }
}
