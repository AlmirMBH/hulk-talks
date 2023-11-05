<?php

namespace App\Http\Controllers\Refactoring;

use App\Helpers\InvoiceHelperTrait;
use App\Http\Controllers\Controller;
use App\Models\Refactoring\Banner;
use App\Models\Refactoring\Invoice;
use App\Services\Refactoring\BannerService;
use App\Services\Refactoring\InvoiceService;

/**
 * DUPLICATE CODE
 * If you see the same code structure in more than one place, you can be sure that your program will be better if you find a way to unify them. Duplication
 * means that every time you read these copies, you need to read them carefully to see if there’s any difference. If you need to change the duplicated
 * code, you have to find and catch each duplication. The simplest duplicated code problem is when you have the same expression in two methods of the same
 * class. Then all you have to do is Extract Function (106) and invoke the code from both places. If you have code that’s similar, but not quite identical,
 * see if you can use Slide Statements (223) to arrange the code so the similar items are all together for easy extraction. If the duplicate fragments are
 * in subclasses of a common base class, you can use Pull Up Method (350) to avoid calling one from another.
 */
class DuplicateCodeController extends Controller
{
    use InvoiceHelperTrait;

    public function __construct(
        private readonly InvoiceService $invoiceService,
        private readonly BannerService $bannerService
    )
    {
    }

    /**
     * ORIGINAL METHODS
     */
    public function printInvoice(int $invoiceId): array
    {
        $banner = Banner::find($invoiceId);

        $title = $banner->title;
        $description = $banner->description;
        $template = $banner->template;

        $invoice = Invoice::find($invoiceId);

        $customer = $invoice->customer;
        $invoiceNumber = $invoice->invoice_number;
        $totalAmount = $invoice->total_amount;
        $paidInstallmentsAmount = $invoice->paid_installments_amount;
        $invoiceDate = $invoice->created_at;

        return [
            'title' => $title,
            'description' => $description,
            'template' => $template,
            'customer' => $customer,
            'invoiceNumber' => $invoiceNumber,
            'totalAmount' => $totalAmount,
            'paidInstallmentsAmount' => $paidInstallmentsAmount,
            'invoiceDate' => $invoiceDate,
            ];
    }

    public function printOutstandingInvoice(int $invoiceId): array
    {
        $banner = Banner::find($invoiceId);

        $title = $banner->title;
        $description = $banner->description;
        $template = $banner->template;

        $invoice = Invoice::find($invoiceId);

        $customer = $invoice->customer;
        $invoiceNumber = $invoice->invoice_number;
        $totalAmount = $invoice->total_amount;
        $paidInstallmentsAmount = $invoice->paid_installments_amount;
        $invoiceDate = $invoice->created_at;

        $outstanding = ($invoice->total_amount - $invoice->paid_installments_amount) / 100 - ($invoice->discount ?? 0)
            - (($invoice->paid_installments_amount / 100) > $invoice->min_bonus_amount ? $invoice->bonus_plus : $invoice->basic_bonus);

        $outstandingAmount = [];

        if ($outstanding > 0) {
            $outstandingAmount = ['outstandingAmount' => round($outstanding, 2)];
        }

        return [
            'title' => $title,
            'description' => $description,
            'template' => $template,
            'customer' => $customer,
            'invoiceNumber' => $invoiceNumber,
            'totalAmount' => $totalAmount,
            'paidInstallmentsAmount' => $paidInstallmentsAmount,
            ...$outstandingAmount,
            'invoiceDate' => $invoiceDate,
        ];
    }


    /**
     * TOP-LEVEL METHODS (REFACTORED)
     */
    public function printInvoiceRefactored(int $invoiceId): array
    {
        return $this->formatOutputData(
            data: array_merge(
                $this->getBanner($invoiceId),
                $this->getInvoiceDetails($invoiceId))
        );
    }

    public function printOutstandingInvoiceRefactored(int $invoiceId): array
    {
        return $this->formatOutputData(
            data: array_merge(
                $this->getBanner($invoiceId),
                $this->getInvoiceDetails(
                    invoiceId: $invoiceId,
                    outstandingAmount: $this->calculateOutstandingInvoiceAmount($invoiceId))
            ));
    }


    /**
     * FINAL METHOD (REFACTORED) - STEP I
     */
    public function printInvoiceMerged(int $invoiceId): array
    {
        return $this->formatOutputData(
            data: array_merge(
                $this->getBanner($invoiceId),
                $this->getInvoiceDetails(
                    invoiceId: $invoiceId,
                    outstandingAmount: $this->calculateOutstandingInvoiceAmount($invoiceId))
            ));
    }


    /**
     * SUB-FUNCTIONS / HELPER-FUNCTIONS (HELPER)
     */
    private function getBanner(int $invoiceId): array
    {
        $banner = Banner::find($invoiceId);

        return [
            $banner->title,
            $banner->description,
            $banner->template
        ];
    }

    private function getInvoiceDetails(int $invoiceId, mixed $outstandingAmount = 0): array
    {
        $invoice = Invoice::find($invoiceId);

        return [
            $invoice->customer,
            $invoice->invoice_number,
            $invoice->total_amount,
            $invoice->paid_installments_amount,
            $outstandingAmount,
            $invoice->created_at
        ];
    }

    private function calculateOutstandingInvoiceAmount(int $invoiceId): int|float
    {
        $invoice = Invoice::find($invoiceId);
        $outstandingAmount = 0;

        if ($invoice->total_amount !== $invoice->paid_installments_amount) {
            $discount = $invoice->discount ?? 0;
            $outstanding = ($invoice->total_amount - $invoice->paid_installments_amount) / 100 - $discount;
            $bonus = ($invoice->paid_installments_amount / 100) > $invoice->min_bonus_amount ? $invoice->bonus_plus : $invoice->basic_bonus;

            $outstandingAmount = $outstanding - $bonus;
        }

        return round($outstandingAmount, 2);
    }

    private function formatOutputData(array $data): array
    {
        return [
            'title' => $data[0],
            'description' => $data[1],
            'template' => $data[2],
            'customer' => $data[3],
            'invoiceNumber' => $data[4],
            'totalAmount' => $data[5],
            'paidInstallmentsAmount' => $data[6],
            ...$this->validateOutstanding($data),
            'invoiceDate' => $data[8],
        ];
    }

    private function validateOutstanding(array $data): array
    {
        $formattedData = [];
        $outstandingValue = $data[7];

        if ($outstandingValue > 0) {
            $formattedData['outstanding'] = $outstandingValue;
        }

        return $formattedData;
    }
}
