<?php

namespace App\Models\Refactoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invoices';

    protected $fillable = [
        'invoice_number',
        'customer',
        'total_amount',
        'paid_installments_amount',
        'discount',
        'basic_bonus',
        'min_bonus_amount',
        'bonus_plus'
    ];
}
