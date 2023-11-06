<?php

namespace App\Models\Refactoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountBalance extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'account_balances';

    protected $fillable = [
        'account_id',
        'balance',
        'currency',
        'user_id'
    ];


    /**
     * AccountBalance constructor prevents the database seeding. Comment the code below to seed the database.
     */
    public function __construct(
        public float $balanceBreakingEncapsulation = 0,
        private float $balance = 0,
        private readonly float $readonlyBalance = 0,
    )
    {
        parent::__construct();
    }


    public function updateBalanceBreakingEncapsulation($amount): float|int
    {
        return $this->balanceBreakingEncapsulation += $amount;
    }

    public function getBreakingEncapsulationBalance(): float|int
    {
        return $this->balanceBreakingEncapsulation;
    }

    public function updateBalance($balance): AccountBalance
    {
        return new AccountBalance(
            balance: $this->balance + $balance
        );
    }

    public function getBalance(): float|int
    {
        return $this->balance;
    }

    public function updateReadonlyBalance($balance): AccountBalance
    {
        return new AccountBalance(
            readonlyBalance: $this->readonlyBalance + $balance
        );
    }

    public function getReadonlyBalance(): float|int
    {
        return $this->readonlyBalance;
    }


}
