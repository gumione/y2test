<?php

namespace common\repositories;

use common\models\RefreshToken;
use common\repositories\interfaces\RefreshTokenRepositoryInterface;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public function create(int $userId, string $token, string $expiresAt): RefreshToken
    {
        $refreshToken = new RefreshToken();
        $refreshToken->user_id = $userId;
        $refreshToken->token = $token;
        $refreshToken->expires_at = $expiresAt;

        if (!$refreshToken->save()) {
            throw new \RuntimeException('Failed to save refresh token: ' . json_encode($refreshToken->getErrors()));
        }

        return $refreshToken;
    }

    public function findByToken(string $token): ?RefreshToken
    {
        return RefreshToken::findOne(['token' => $token]);
    }

    public function deleteByToken(string $token): void
    {
        $refreshToken = $this->findByToken($token);
        if ($refreshToken) {
            $refreshToken->delete();
        }
    }

    public function exists(string $token): bool
    {
        return RefreshToken::find()->where(['token' => $token])->exists();
    }
}
