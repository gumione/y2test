<?php

namespace frontend\controllers;

use common\services\interfaces\DocumentServiceInterface;
use common\dto\UploadDocumentDto;
use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;

/**
 * @OA\Tag(
 *     name="Documents",
 *     description="Document management actions"
 * )
 */
class DocumentController extends Controller
{
    private readonly DocumentServiceInterface $documentService;

    public function __construct($id, $module, DocumentServiceInterface $documentService, $config = [])
    {
        $this->documentService = $documentService;
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
     * @OA\Post(
     *     path="/document/upload",
     *     summary="Upload user documents",
     *     tags={"Documents"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="files",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary")
     *                 ),
     *                 @OA\Property(property="document_type_id", type="integer", example=1)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Documents uploaded successfully"
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
    public function actionUpload()
    {
        $data = Yii::$app->request->post();
        $files = \yii\web\UploadedFile::getInstancesByName('files');

        $dto = new UploadDocumentDto($files, $data['document_type_id'] ?? null, Yii::$app->user->id);

        if (!$dto->validate()) {
            Yii::$app->response->statusCode = 400;
            return [
                'errors' => $dto->getErrors(),
            ];
        }

        try {
            $this->documentService->uploadDocuments($dto);
            Yii::$app->response->statusCode = 200;
            return [
                'message' => Yii::t('app', 'Documents uploaded successfully'),
            ];
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
     *     path="/document/view/{id}",
     *     summary="View document",
     *     tags={"Documents"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Document ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document file"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access denied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function actionView($id)
    {
        $userId = Yii::$app->user->id;

        try {
            $filePath = $this->documentService->getFilePath((int)$id, $userId);

            return Yii::$app->response->sendFile($filePath);
        } catch (\DomainException $e) {
            Yii::$app->response->statusCode = 403;
            return [
                'error' => $e->getMessage(),
            ];
        } catch (\RuntimeException $e) {
            Yii::$app->response->statusCode = 404;
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}
