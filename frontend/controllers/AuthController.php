<?php

namespace frontend\controllers;

use common\services\interfaces\AuthServiceInterface;
use common\dto\RegisterDto;
use common\dto\LoginDto;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Authentication related actions"
 * )
 */
class AuthController extends Controller
{
    private readonly AuthServiceInterface $authService;

    public function __construct($id, $module, AuthServiceInterface $authService, $config = [])
    {
        $this->authService = $authService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => \yii\filters\auth\HttpBearerAuth::class,
                'optional' => ['register', 'login', 'refresh', 'logout'],
            ],
        ];
    }

    /**
     * @OA\Post(
     *     path="/auth/register",
     *     summary="Register a new user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="username", type="string", example="user1"),
     *             @OA\Property(property="email", type="string", example="user1@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     )
     * )
     */
    public function actionRegister()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $dto = new RegisterDto($data);

        if (!$dto->validate()) {
            Yii::$app->response->statusCode = 400;
            return [
                'errors' => $dto->getErrors(),
            ];
        }

        $user = $this->authService->register($dto);

        if (!$user) {
            throw new BadRequestHttpException(Yii::t('app', 'Could not register user'));
        }

        Yii::$app->response->statusCode = 201;
        return $user->getAttributes(['id', 'username', 'email']);
    }

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     summary="Login a user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function actionLogin()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $dto = new LoginDto($data);

        if (!$dto->validate()) {
            Yii::$app->response->statusCode = 400;
            return [
                'errors' => $dto->getErrors(),
            ];
        }

        $token = $this->authService->login($dto);

        if (!$token) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Invalid credentials'));
        }

        return ['token' => $token];
    }

    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     summary="Refresh access token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="refresh_token", type="string", example="refresh_token_here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="New access token"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid or expired refresh token"
     *     )
     * )
     */
    public function actionRefresh()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $refreshToken = $data['refresh_token'] ?? null;

        if (!$refreshToken) {
            Yii::$app->response->statusCode = 400;
            return [
                'error' => Yii::t('app', 'Refresh token is required'),
            ];
        }

        $newAccessToken = $this->authService->refreshAccessToken($refreshToken);
        if (!$newAccessToken) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Invalid or expired refresh token'));
        }

        return ['access_token' => $newAccessToken];
    }

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     summary="Logout user",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="refresh_token", type="string", example="refresh_token_here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function actionLogout()
    {
        $data = json_decode(Yii::$app->request->getRawBody(), true);
        $refreshToken = $data['refresh_token'] ?? null;

        if (!$refreshToken) {
            Yii::$app->response->statusCode = 400;
            return [
                'error' => Yii::t('app', 'Refresh token is required'),
            ];
        }

        $result = $this->authService->revokeRefreshToken($refreshToken);

        if (!$result) {
            throw new UnauthorizedHttpException(Yii::t('app', 'Invalid or expired refresh token'));
        }

        return [
            'message' => Yii::t('app', 'Logged out successfully'),
        ];
    }
}
