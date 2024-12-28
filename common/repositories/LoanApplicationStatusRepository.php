<?php

namespace common\repositories;

use common\models\LoanApplicationStatus;
use common\repositories\interfaces\LoanApplicationStatusRepositoryInterface;

class LoanApplicationStatusRepository implements LoanApplicationStatusRepositoryInterface
{
    public function findById(int $id): ?LoanApplicationStatus
    {
        return LoanApplicationStatus::findOne($id);
    }

    public function findByName(string $name): ?LoanApplicationStatus
    {
        return LoanApplicationStatus::findOne(['name' => $name]);
    }

    public function getAll(): array
    {
        return LoanApplicationStatus::find()
            ->select(['id', 'name'])
            ->indexBy('id')
            ->asArray()
            ->all();
    }
    
    public function existsById(int $id): bool
    {
        return LoanApplicationStatus::find()->where(['id' => $id])->exists();
    }
}
