<?php

namespace common\services;

use common\repositories\interfaces\LoanApplicationRepositoryInterface;
use common\services\interfaces\DebtClearingServiceInterface;

class DebtClearingService implements DebtClearingServiceInterface
{
    public function __construct(private readonly LoanApplicationRepositoryInterface $loanRepository)
    {
    }

    public function clearRandomDebt(): bool
    {
        $loansWithDebt = $this->loanRepository->getAllWithDebt();
        if (empty($loansWithDebt)) {
            return false;
        }

        $chosenLoan = $loansWithDebt[array_rand($loansWithDebt)];
        $chosenLoan->outstanding_balance = 0;

        return $this->loanRepository->save($chosenLoan);
    }
}
