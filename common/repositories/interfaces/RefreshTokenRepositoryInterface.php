<?php

namespace common\repositories\interfaces;

use common\models\RefreshToken;

interface RefreshTokenRepositoryInterface
{
    public function create(int $userId, string $token, string $expiresAt): RefreshToken;
    
    public function findByToken(string $token): ?RefreshToken;
    
    public function deleteByToken(string $token): void;
    
    public function exists(string $token): bool;
}
