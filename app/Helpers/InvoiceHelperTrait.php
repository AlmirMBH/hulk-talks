<?php

namespace App\Helpers;

use App\Models\Refactoring\Banner;
use App\Models\Refactoring\Invoice;
use Illuminate\Support\Arr;

trait InvoiceHelperTrait
{
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
            'title' => Arr::get($data, 0),
            'description' => Arr::get($data, 1),
            'template' => Arr::get($data, 2),
            'customer' => Arr::get($data, 3),
            'invoiceNumber' => Arr::get($data, 4),
            'totalAmount' => Arr::get($data, 5),
            'paidInstallmentsAmount' => Arr::get($data, 6),
            ...$this->validateOutstanding($data),
            'invoiceDate' => Arr::get($data, 8),
        ];
    }

    private function validateOutstanding(array $data): array
    {
        $formattedData = [];
        $outstandingValue = Arr::get($data, 7);

        if ($outstandingValue > 0) {
            $formattedData['outstanding'] = $outstandingValue;
        }

        return $formattedData;
    }
}
