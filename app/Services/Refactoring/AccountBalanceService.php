<?php

namespace App\Services\Refactoring;

use App\Repositories\Interfaces\Refactoring\AccountBalanceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class AccountBalanceService
{
    public function __construct(
        private readonly AccountBalanceRepositoryInterface $accountBalanceRepository
    )
    {
    }

    public function getAccountBalanceById(int $accountBalanceId): Model
    {
        return $this->accountBalanceRepository->find($accountBalanceId);
    }

    public function createAccountBalance(array $data): Model
    {
        return $this->accountBalanceRepository->create($data);

    }

    public function updateAccountBalance(int $accountBalanceId, array $data): Model
    {
        return $this->accountBalanceRepository->update($accountBalanceId, $data);
    }
}
