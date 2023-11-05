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

    public function printInvoiceFinal(int $invoiceId): array
    {
        $invoice = $this->invoiceService->findById($invoiceId);
        $banner = $this->bannerService->findById($invoiceId);

        return $this->formatOutputData(
            data: array_merge(
                $this->formatBanner($banner),
                $this->formatInvoiceDetails(
                    invoice: $invoice,
                    outstandingAmount: $this->calculateOutstandingInvoiceAmount($invoice))
            ));
    }
}
