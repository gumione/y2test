<?php

namespace common\repositories;

use common\models\User;
use common\repositories\interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        return User::findOne($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::findOne(['email' => $email]);
    }

    public function findByUsername(string $username): ?User
    {
        return User::findOne(['username' => $username]);
    }

    public function findByAccessToken(string $token): ?User
    {
        return User::findOne(['access_token' => $token]);
    }

    public function save(User $user): bool
    {
        return $user->save();
    }
}
