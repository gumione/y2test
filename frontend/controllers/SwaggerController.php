<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @OA\Info(
 *     title="Loan Application API",
 *     version="1.0.0"
 * )
 * 
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * 
 * @OA\PathItem(
 *     path="/swagger"
 * )
 */
class SwaggerController extends Controller
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'light\swagger\SwaggerAction',
                'restUrl' => Url::to(['swagger/json'], true),
            ],
            'json' => [
                'class' => 'light\swagger\SwaggerApiAction',
                'scanDir' => [
                    Yii::getAlias('@frontend/controllers'),
                    Yii::getAlias('@common/models'),
                    Yii::getAlias('@common/swagger/Schemas')
                ],
            ],
        ];
    }
}
