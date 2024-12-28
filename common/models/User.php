<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\repositories\interfaces\UserRepositoryInterface;
use common\services\interfaces\AuthServiceInterface;

/**
 * @OA\Schema(
 *     schema="User",
 *     title="User Model",
 *     description="Details of the user",
 *     @OA\Property(property="id", type="integer", description="Unique user ID"),
 *     @OA\Property(property="username", type="string", description="Username of the user"),
 *     @OA\Property(property="email", type="string", description="Email address of the user"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", description="User's date of birth"),
 *     @OA\Property(property="passport_number", type="string", description="Passport number"),
 *     @OA\Property(property="passport_expiry_date", type="string", format="date", description="Passport expiry date"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Record creation timestamp"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Record last update timestamp")
 * )
 */
class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['email', 'username'], 'required'],
            ['email', 'email'],
            [['email', 'username'], 'unique'],
            [['password_hash', 'auth_key'], 'string'],
            ['date_of_birth', 'date', 'format' => 'php:Y-m-d'],
            ['passport_number', 'string'],
            ['passport_expiry_date', 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public static function findIdentity($id)
    {
        $repository = \Yii::$container->get(UserRepositoryInterface::class);
        return $repository->findById((int)$id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $authService = Yii::$container->get(AuthServiceInterface::class);
        $data = $authService->validateToken($token);

        if ($data) {
            return self::findOne(['id' => $data['sub']]);
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function setPassword($password)
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword($password)
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['user_id' => 'id']);
    }

    public function getLoanApplications()
    {
        return $this->hasMany(LoanApplication::class, ['user_id' => 'id']);
    }
}
