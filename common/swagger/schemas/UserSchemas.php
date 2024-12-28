<?php

namespace common\swagger\Schemas;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UpdateUserDto",
 *     title="Update User DTO",
 *     description="Schema for updating user details",
 *     @OA\Property(property="username", type="string", example="new_username"),
 *     @OA\Property(property="email", type="string", example="user@example.com"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
 *     @OA\Property(property="passport_number", type="string", example="AB1234567"),
 *     @OA\Property(property="passport_expiry_date", type="string", format="date", example="2030-01-01")
 * )
 */
class UserSchemas
{
}
