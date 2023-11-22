<?php

namespace App\Http\Controllers\Refactoring;

use App\Helpers\InvoiceHelperFinalTrait;
use App\Http\Controllers\Controller;
use App\Services\Refactoring\BannerService;
use App\Services\Refactoring\InvoiceService;

class DuplicateCodeFinalController extends Controller
{
    use InvoiceHelperFinalTrait;

    public function __construct(
        private readonly InvoiceService $invoiceService,
        private readonly BannerService $bannerService
    )
    {
    }

    /**
     * TOP-LEVEL METHOD(S) (REFACTORED) - STEP II
     * Extract duplicate code in separate methods
     * Format response in a separate method
     * Check if the invoice is outstanding in a separate method
     * Move methods to trait ar helper class
     * Merge invoice and outstanding invoice methods into one method
     * Use Object-oriented approach; pass objects instead of primitive data types (avoid tight coupling)
     *
     * Fetch data from database via data-access layer i.e. repository pattern
     * (not within the scope of this lecture)
     */
    public function printInvoiceFinal(int $invoiceId): array
    {
        $invoice = $this->invoiceService->findById($invoiceId);
        $banner = $this->bannerService->findById($invoiceId);
        $outstandingAmount = $this->calculateOutstandingInvoiceAmount($invoice);

        return $this->formatOutputData(
            banner: $banner,
            invoice: $invoice,
            outstandingAmount: $outstandingAmount
        );
    }
}
