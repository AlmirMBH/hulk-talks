<?php

namespace App\Repositories\Refactoring;

use App\Models\Refactoring\AccountBalance;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Refactoring\AccountBalanceRepositoryInterface;

class AccountBalanceRepository extends BaseRepository implements AccountBalanceRepositoryInterface
{
    public function __construct(AccountBalance $model)
    {
        parent::__construct($model);
    }
}
