<?php

namespace App\Helpers;

use App\Models\Refactoring\Banner;
use App\Models\Refactoring\Invoice;

trait LongParameterListTrait
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

    private function validateOutstanding(mixed $data, ?bool $printOutstandingAmount = false): array
    {
        $outstandingAmount = [];

        $outstandingValue = match(true) {
            is_object($data) => $data->getOutstandingAmount(),
            default => $data,
        };

        if ($printOutstandingAmount && $outstandingValue > 0) {
            $outstandingAmount = ['outstanding' => $outstandingValue];
        }

        return $outstandingAmount;
    }
}
