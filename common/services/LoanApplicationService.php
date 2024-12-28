<?php

namespace common\services;

use common\models\LoanApplication;
use common\repositories\interfaces\LoanApplicationRepositoryInterface;
use common\repositories\interfaces\LoanApplicationStatusRepositoryInterface;
use common\services\interfaces\LoanApplicationServiceInterface;

class LoanApplicationService implements LoanApplicationServiceInterface
{
    public function __construct(
        private readonly LoanApplicationRepositoryInterface $loanRepository,
        private readonly LoanApplicationStatusRepositoryInterface $statusRepository
    ) {}

    public function createLoan(array $data, int $userId): ?LoanApplication
    {
        $loan = new LoanApplication();
        $loan->user_id = $userId;
        $loan->loan_amount = $data['loan_amount'];
        $loan->loan_term = $data['loan_term'];
        $loan->loan_purpose = $data['loan_purpose'];
        $loan->monthly_income = $data['monthly_income'];
        $loan->status = $this->statusRepository->findById(1)->id;
        $loan->outstanding_balance = $data['loan_amount'];

        if ($this->loanRepository->save($loan)) {
            return $loan;
        }
        return null;
    }

    public function updateStatus(int $loanId, string $status): bool
    {
        $loan = $this->loanRepository->findById($loanId);
        if (!$loan) {
            return false;
        }

        $loan->status = $this->getStatusIdByName($status);
        return $this->loanRepository->save($loan);
    }
    
    public function getLoansByUser(int $userId): array
    {
        return $this->loanRepository->findAllByUserId($userId);
    }

    public function getLoanByIdAndUser(int $loanId, int $userId): ?LoanApplication
    {
        $loan = $this->loanRepository->findById($loanId);
        return ($loan && $loan->user_id === $userId) ? $loan : null;
    }
}
