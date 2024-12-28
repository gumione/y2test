<?php

namespace frontend\controllers;

use common\services\interfaces\DocumentTypeServiceInterface;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

/**
 * @OA\Tag(
 *     name="Document Types",
 *     description="Manage document types"
 * )
 */
class DocumentTypeController extends Controller
{
    private readonly DocumentTypeServiceInterface $documentTypeService;

    public function __construct($id, $module, DocumentTypeServiceInterface $documentTypeService, $config = [])
    {
        $this->documentTypeService = $documentTypeService;
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
     * @OA\Get(
     *     path="/document-type/list",
     *     summary="Get all document types",
     *     tags={"Document Types"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of document types",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Passport"),
     *                 @OA\Property(property="description", type="string", example="A valid passport document")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Unauthorized")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Internal server error")
     *         )
     *     )
     * )
     */
    public function actionList()
    {
        try {
            $documentTypes = $this->documentTypeService->getAllDocumentTypes();
            Yii::$app->response->statusCode = 200;

            return $documentTypes;
        } catch (\RuntimeException $e) {
            Yii::$app->response->statusCode = 500;
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
