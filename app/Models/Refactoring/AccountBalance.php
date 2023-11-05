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

    public $balanceBreakingEncapsulation;
    private float $balance;

    public function __construct()
    {
        parent::__construct();
        $this->balanceBreakingEncapsulation = 0;
        $this->balance = 0;
    }

    // Incorrect method for updating the balance
    public function updateBalance($amount): void
    {
        $this->balance += $amount;
    }

    public function getBalance(): float|int
    {
        return $this->balance;
    }
}
