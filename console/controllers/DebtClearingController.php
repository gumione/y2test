<?php

namespace console\controllers;

use common\services\interfaces\DebtClearingServiceInterface;
use yii\console\Controller;

class DebtClearingController extends Controller
{
    private readonly DebtClearingServiceInterface $debtClearingService;

    public function __construct($id, $module, DebtClearingServiceInterface $debtClearingService, $config = [])
    {
        $this->debtClearingService = $debtClearingService;
        parent::__construct($id, $module, $config);
    }

    public function actionRun(): void
    {
        $res = $this->debtClearingService->clearRandomDebt();
        if ($res) {
            echo "Debt cleared for a random user.\n";
        } else {
            echo "No debt to clear.\n";
        }
    }
}
