<?php

namespace common\services\interfaces;

interface DebtClearingServiceInterface
{
    public function clearRandomDebt(): bool;
}
