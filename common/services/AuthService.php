<?php

namespace common\services;

use common\repositories\interfaces\UserRepositoryInterface;
use common\models\User;
use Yii;
use common\services\interfaces\AuthServiceInterface;
use common\repositories\interfaces\RefreshTokenRepositoryInterface;
use common\dto\RegisterDto;
use common\dto\LoginDto;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService implements AuthServiceInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository, private RefreshTokenRepositoryInterface $refreshTokenRepository) {}

    public function register(RegisterDto $dto): ?User
    {
        $user = new User();
        $user->username = $dto->username;
        $user->email = $dto->email;
        $user->setPassword($dto->password);
        $user->auth_key = Yii::$app->security->generateRandomString();

        if ($this->userRepository->save($user)) {
            return $user;
        }
        return null;
    }

    public function login(LoginDto $dto): ?array
    {
        $user = $this->userRepository->findByEmail($dto->email);
        if (!$user || !Yii::$app->security->validatePassword($dto->password, $user->password_hash)) {
            return null;
        }

        $accessToken = $this->generateToken($user);
        $refreshToken = $this->generateRefreshToken($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }
    
    private function generateToken(User $user): string
    {
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + Yii::$app->params['jwtExpire'],
        ];

        return JWT::encode($payload, Yii::$app->params['jwtSecret'], 'HS256');
    }

    public function generateRefreshToken(User $user): string
    {
        $token = Yii::$app->security->generateRandomString(64);
        $expiresAt = date('Y-m-d H:i:s', time() + 3600 * 24 * 30);

        $this->refreshTokenRepository->create($user->id, $token, $expiresAt);

        return $token;
    }

    public function refreshAccessToken(string $refreshToken): ?string
    {
        $token = $this->refreshTokenRepository->findByToken($refreshToken);
        if (!$token || strtotime($token->expires_at) < time()) {
            return null;
        }

        $user = User::findOne($token->user_id);
        if (!$user) {
            return null;
        }

        return $this->generateToken($user);
    }

    public function revokeRefreshToken(string $refreshToken): bool
    {
        if (!$this->refreshTokenRepository->exists($refreshToken)) {
            return false;
        }

        $this->refreshTokenRepository->deleteByToken($refreshToken);
        return true;
    }
    
    public function validateToken(string $token): ?array
    {
        try {
            $decoded = (array) JWT::decode($token, new Key(Yii::$app->params['jwtSecret'], 'HS256'));
            return $decoded;
        } catch (\Exception $e) {
            Yii::error('JWT validation failed: ' . $e->getMessage(), __METHOD__);
            return null;
        }
    }

}
