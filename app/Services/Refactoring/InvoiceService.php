<?php

namespace App\Services\Refactoring;

use App\Repositories\Interfaces\Refactoring\InvoiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class InvoiceService
{
    public function __construct(
        private InvoiceRepositoryInterface $invoiceRepository
    )
    {
    }

    public function findById(int $invoiceId): Model
    {
        return $this->invoiceRepository->find($invoiceId);
    }

}
