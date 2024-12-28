<?php

namespace common\repositories\interfaces;

use common\models\LoanApplicationStatus;

interface LoanApplicationStatusRepositoryInterface
{
    public function findById(int $id): ?LoanApplicationStatus;
    public function findByName(string $name): ?LoanApplicationStatus;
    public function getAll(): array;
}
