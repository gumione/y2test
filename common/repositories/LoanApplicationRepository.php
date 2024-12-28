<?php

namespace common\repositories;

use common\models\LoanApplication;
use common\repositories\interfaces\LoanApplicationRepositoryInterface;

class LoanApplicationRepository implements LoanApplicationRepositoryInterface
{
    public function findById(int $id): ?LoanApplication
    {
        return LoanApplication::findOne($id);
    }

    public function findAllByUserId(int $userId): array
    {
        return LoanApplication::findAll(['user_id' => $userId]);
    }

    public function save(LoanApplication $loan): bool
    {
        return $loan->save();
    }

    public function findAllByStatus(int $status): array
    {
        return LoanApplication::findAll(['status' => $status]);
    }

    public function getAllWithDebt(): array
    {
        return LoanApplication::find()->where(['>', 'outstanding_balance', 0])->all();
    }
    
    public function existsById(int $id): bool
    {
        return LoanApplication::find()->where(['id' => $id])->exists();
    }
}
