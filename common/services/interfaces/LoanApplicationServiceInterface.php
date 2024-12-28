<?php

namespace common\services\interfaces;

use common\models\LoanApplication;

interface LoanApplicationServiceInterface
{
    public function createLoan(array $data, int $userId): ?LoanApplication;
    public function updateStatus(int $loanId, string $status): bool;
    public function getLoansByUser(int $userId): array;
    public function getLoanByIdAndUser(int $loanId, int $userId): ?LoanApplication;
}
