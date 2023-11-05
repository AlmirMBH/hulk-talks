<?php

namespace App\Repositories\Refactoring;

use App\Models\Refactoring\Invoice;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\Refactoring\InvoiceRepositoryInterface;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{
    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }
}
