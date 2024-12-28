<?php

namespace frontend\controllers;

use common\services\interfaces\LoanApplicationServiceInterface;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * @OA\Tag(name="Loan Applications", description="Endpoints for managing loan applications")
 */
class LoanApplicationController extends Controller
{
    private readonly LoanApplicationServiceInterface $loanApplicationService;

    public function __construct($id, $module, LoanApplicationServiceInterface $loanApplicationService, $config = [])
    {
        $this->loanApplicationService = $loanApplicationService;
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
     *     path="/loan-applications",
     *     summary="Create a new loan application",
     *     tags={"Loan Applications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="loan_amount", type="integer", example=5000),
     *             @OA\Property(property="loan_term", type="integer", example=24),
     *             @OA\Property(property="loan_purpose", type="string", example="Home renovation"),
     *             @OA\Property(property="monthly_income", type="integer", example=3000)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Loan application created successfully"),
     *     @OA\Response(response=400, description="Validation error"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function actionCreate()
    {
        $userId = Yii::$app->user->id;

        if (!$userId) {
            throw new UnauthorizedHttpException('User is not authenticated.');
        }

        $data = Yii::$app->request->getBodyParams();

        $dto = new \common\dto\CreateLoanApplicationDto();
        $dto->setAttributes($data);

        if (!$dto->validate()) {
            Yii::$app->response->statusCode = 400;
            return [
                'errors' => $dto->getErrors(),
            ];
        }

        $loan = $this->loanApplicationService->createLoan($dto->getAttributes(), $userId);

        if (!$loan) {
            throw new BadRequestHttpException('Failed to create loan application.');
        }

        Yii::$app->response->statusCode = 201;
        return $loan;
    }

    /**
     * @OA\Get(
     *     path="/loan-applications",
     *     summary="Get all loan applications for the current user",
     *     tags={"Loan Applications"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response=200, description="List of loan applications"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function actionIndex()
    {
        $userId = Yii::$app->user->id;

        if (!$userId) {
            throw new UnauthorizedHttpException('User is not authenticated.');
        }

        $loans = $this->loanApplicationService->getLoansByUser($userId);

        Yii::$app->response->statusCode = 200;
        return $loans;
    }
}
