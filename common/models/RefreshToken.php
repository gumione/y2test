<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * @OA\Schema(
 *     schema="RefreshToken",
 *     title="Refresh Token Model",
 *     description="Details of the refresh token",
 *     @OA\Property(property="id", type="integer", description="Unique token ID"),
 *     @OA\Property(property="user_id", type="integer", description="User ID associated with the token"),
 *     @OA\Property(property="token", type="string", description="The refresh token string"),
 *     @OA\Property(property="expires_at", type="string", format="date-time", description="Expiration time of the token"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Record creation timestamp")
 * )
 */
class RefreshToken extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%refresh_tokens}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'token', 'expires_at'], 'required'],
            ['token', 'string', 'max' => 512],
            ['token', 'unique'],
            ['expires_at', 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function fields()
    {
        return ['id', 'user_id', 'token', 'expires_at', 'created_at'];
    }
}

