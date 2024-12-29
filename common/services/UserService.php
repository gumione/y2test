<?php

namespace common\services;

use common\dto\UpdateUserDto;
use common\models\User;
use common\repositories\interfaces\UserRepositoryInterface;
use common\services\interfaces\UserServiceInterface;

class UserService implements UserServiceInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository) {}

    public function updateUser(User $user, UpdateUserDto $dto): bool
    {
        if (!$dto->validate()) {
            throw new \DomainException('Invalid data: ' . json_encode($dto->getErrors()));
        }

        $user->setAttributes($dto->getAttributes(), false);

        if (!$this->userRepository->save($user)) {
            throw new \RuntimeException('Failed to update user data.');
        }

        return true;
    }
}
