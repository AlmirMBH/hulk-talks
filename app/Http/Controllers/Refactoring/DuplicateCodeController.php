<?php

namespace App\Http\Controllers\Refactoring;

use App\Http\Controllers\Controller;
use App\Models\Refactoring\Banner;
use App\Models\Refactoring\Invoice;

/**
 * DUPLICATE CODE
 */
class DuplicateCodeController extends Controller
{
    /**
     * ORIGINAL METHODS
     * What issues could the 2 methods below cause in the future?
     */

    /**
     * FOOD FOR THOUGHT / QUESTIONS
     * What if we need to add more data to the invoice?
     * What if we need to add more data to the banner?
     * What if we need to add more data to the response?
     *
     * What can we do to improve the code?
     */
    public function printInvoice(int $invoiceId): array
    {
        // Banner
        $banner = Banner::find($invoiceId);
        $title = $banner->title;
        $description = $banner->description;
        $template = $banner->template;

        // Invoice
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
        // Banner
        $banner = Banner::find($invoiceId);
        $title = $banner->title;
        $description = $banner->description;
        $template = $banner->template;

        // Invoice
        $invoice = Invoice::find($invoiceId);
        $customer = $invoice->customer;
        $invoiceNumber = $invoice->invoice_number;
        $totalAmount = $invoice->total_amount;
        $paidInstallmentsAmount = $invoice->paid_installments_amount;
        $invoiceDate = $invoice->created_at;

        // Outstanding
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
     * TOP-LEVEL METHODS (REFACTORED) - STEP I
     * Extract duplicate code into separate methods
     */
    public function printInvoiceRefactored(int $invoiceId): array
    {
        // Banner, Invoice & Outstanding
        $banner = $this->getBanner($invoiceId);
        $invoice = $this->getInvoiceDetails($invoiceId);
        $outstandingAmount = $invoice[4] > 0 ? ['outstanding' => $invoice[4]] : [];

        // Output
        return [
            'title' => $banner[0],
            'description' => $banner[1],
            'template' => $banner[2],
            'customer' => $invoice[0],
            'invoiceNumber' => $invoice[1],
            'totalAmount' => $invoice[2],
            'paidInstallmentsAmount' => $invoice[3],
            ...$outstandingAmount,
            'invoiceDate' => $invoice[5],
        ];
    }

    public function printOutstandingInvoiceRefactored(int $invoiceId): array
    {
        // Banner, Invoice & Outstanding
        $banner = $this->getBanner($invoiceId);
        $invoice = $this->getInvoiceDetails($invoiceId, $this->calculateOutstandingInvoiceAmount($invoiceId));
        $outstandingAmount = $invoice[4] > 0 ? ['outstanding' => $invoice[4]] : [];

        // Output
        return [
            'title' => $banner[0],
            'description' => $banner[1],
            'template' => $banner[2],
            'customer' => $invoice[0],
            'invoiceNumber' => $invoice[1],
            'totalAmount' => $invoice[2],
            'paidInstallmentsAmount' => $invoice[3],
            ...$outstandingAmount,
            'invoiceDate' => $invoice[5],
        ];
    }



    // Banner
    private function getBanner(int $invoiceId): array
    {
        $banner = Banner::find($invoiceId);

        return [
            $banner->title,
            $banner->description,
            $banner->template
        ];
    }

    // Invoice
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

    // Outstanding
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



    /**
     * TOP-LEVEL METHOD(S) (REFACTORED) - STEP II
     * Merge invoice and outstanding invoice methods into one method
     * Format response in a separate method
     * Check if the invoice is outstanding in a separate method
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

    // Output
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
            ...$this->getOutstandingAmount($data),
            'invoiceDate' => $data[8],
        ];
    }

    // Outstanding (validation)
    private function getOutstandingAmount(array $data): array
    {
        $formattedData = [];
        $outstandingValue = $data[7];

        if ($outstandingValue > 0) {
            $formattedData['outstanding'] = $outstandingValue;
        }

        return $formattedData;
    }
}
