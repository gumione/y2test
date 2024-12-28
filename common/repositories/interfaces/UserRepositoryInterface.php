<?php

namespace common\repositories\interfaces;

use common\models\User;

interface UserRepositoryInterface
{
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function findByUsername(string $username): ?User;
    public function findByAccessToken(string $token): ?User;
    public function save(User $user): bool;
}
