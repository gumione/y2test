<?php

namespace common\repositories\interfaces;

use common\models\LoanApplication;

interface LoanApplicationRepositoryInterface
{
    public function findById(int $id): ?LoanApplication;
    public function findAllByUserId(int $userId): array;
    public function save(LoanApplication $loan): bool;
    public function findAllByStatus(int $status): array;
    public function getAllWithDebt(): array;
    public function existsById(int $id): bool;
}
