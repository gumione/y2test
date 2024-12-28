<?php

namespace frontend\controllers;

use common\dto\UpdateUserDto;
use common\services\interfaces\UserServiceInterface;
use Yii;
use yii\rest\Controller;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;
use yii\web\BadRequestHttpException;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="User management actions"
 * )
 */
class UserController extends Controller
{
    private readonly UserServiceInterface $userService;

    public function __construct($id, $module, UserServiceInterface $userService, $config = [])
    {
        $this->userService = $userService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'authenticator' => [
                'class' => HttpBearerAuth::class,
            ],
        ];
    }

    /**
     * @OA\Put(
     *     path="/user/update",
     *     summary="Update user data",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateUserDto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User data updated successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function actionUpdate()
    {
        $data = Yii::$app->request->getBodyParams();

        $dto = new UpdateUserDto($data);

        // Валидация DTO
        if (!$dto->validate()) {
            Yii::$app->response->statusCode = 400;
            return [
                'errors' => $dto->getErrors(),
            ];
        }

        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        try {
            $this->userService->updateUser($user, $dto);
            Yii::$app->response->statusCode = 200;
            return $user->getAttributes([
                'id',
                'username',
                'email',
                'date_of_birth',
                'passport_number',
                'passport_expiry_date',
                'created_at',
                'updated_at',
            ]);
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 400;
            return [
                'error' => $e->getMessage(),
            ];
        } catch (\RuntimeException $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'error' => Yii::t('app', 'Internal server error. Please try again later.'),
            ];
        }
    }

    /**
     * @OA\Get(
     *     path="/user/view",
     *     summary="View current user data",
     *     tags={"Users"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Current user data",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/User"
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function actionView()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new UnauthorizedHttpException('Unauthorized');
        }

        Yii::$app->response->statusCode = 200;
        return $user->getAttributes([
            'id',
            'username',
            'email',
            'date_of_birth',
            'passport_number',
            'passport_expiry_date',
            'created_at',
            'updated_at',
        ]);
    }
}
