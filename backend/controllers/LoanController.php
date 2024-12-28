<?php

namespace backend\controllers;

use common\services\interfaces\LoanServiceInterface;
use common\repositories\interfaces\LoanApplicationRepositoryInterface;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;

class LoanController extends AdminBaseController
{
    private readonly LoanServiceInterface $loanService;
    private readonly LoanApplicationRepositoryInterface $loanRepository;

    public function __construct(
        $id, 
        $module, 
        LoanServiceInterface $loanService,
        LoanApplicationRepositoryInterface $loanRepository,
        $config = []
    ) {
        $this->loanService = $loanService;
        $this->loanRepository = $loanRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->loanRepository->getQuery(),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $loan = $this->loanRepository->findById($id);
        if (!$loan) {
            throw new NotFoundHttpException(Yii::t('loan', 'Loan not found.'));
        }

        return $this->render('view', ['loan' => $loan]);
    }

    public function actionCreate()
    {
        $loan = new \common\models\LoanApplication();

        if (Yii::$app->request->isPost && $loan->load(Yii::$app->request->post()) && $this->loanRepository->save($loan)) {
            return $this->redirect(['view', 'id' => $loan->id]);
        }

        return $this->render('create', ['loan' => $loan]);
    }

    public function actionUpdate($id)
    {
        $loan = $this->loanRepository->findById($id);
        if (!$loan) {
            throw new NotFoundHttpException(Yii::t('loan', 'Loan not found.'));
        }

        if (Yii::$app->request->isPost && $loan->load(Yii::$app->request->post()) && $this->loanRepository->save($loan)) {
            return $this->redirect(['view', 'id' => $loan->id]);
        }

        return $this->render('update', ['loan' => $loan]);
    }

    public function actionDelete($id)
    {
        $loan = $this->loanRepository->findById($id);
        if (!$loan) {
            throw new NotFoundHttpException(Yii::t('loan', 'Loan not found.'));
        }

        if (!$loan->delete()) {
            throw new ServerErrorHttpException(Yii::t('loan', 'Failed to delete loan.'));
        }

        return $this->redirect(['index']);
    }

    public function actionApprove($id)
    {
        if ($this->loanService->updateStatus($id, 'approved')) {
            return $this->redirect(['view', 'id' => $id]);
        }

        throw new ServerErrorHttpException(Yii::t('loan', 'Failed to approve loan.'));
    }

    public function actionReject($id)
    {
        if ($this->loanService->updateStatus($id, 'rejected')) {
            return $this->redirect(['view', 'id' => $id]);
        }

        throw new ServerErrorHttpException(Yii::t('loan', 'Failed to reject loan.'));
    }
}
