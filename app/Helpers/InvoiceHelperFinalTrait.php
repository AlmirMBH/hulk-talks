<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

trait InvoiceHelperFinalTrait
{
    // Outstanding
    private function calculateOutstandingInvoiceAmount(Model $invoice): int|float
    {
        $outstandingAmount = 0;

        if ($invoice->total_amount > $invoice->paid_installments_amount) {
            $discount = $invoice->discount ?? 0;

            $outstanding = ($invoice->total_amount - $invoice->paid_installments_amount) / 100 - $discount;

            $bonus = ($invoice->paid_installments_amount / 100) > $invoice->min_bonus_amount
                ? $invoice->bonus_plus : $invoice->basic_bonus;

            $outstandingAmount = $outstanding - $bonus;
        }

        return round($outstandingAmount, 2);
    }


    // Output
    private function formatOutputData(Model $banner, Model $invoice, int|float $outstandingAmount): array
    {
        return [
            'title' => $banner->title,
            'description' => $banner->description,
            'template' => $banner->template,
            'customer' => $invoice->customer,
            'invoiceNumber' => $invoice->invoice_number,
            'totalAmount' => $invoice->total_amount,
            'paidInstallmentsAmount' => $invoice->paid_installments_amount,
            ...$this->getOutstandingAmount($outstandingAmount),
            'invoiceDate' => $invoice->created_at,
        ];
    }


    // Outstanding validation
    private function getOutstandingAmount(int|float $outstandingAmount): array
    {
        $formattedData = [];

        if ($outstandingAmount > 0) {
            $formattedData['outstanding'] = $outstandingAmount;
        }

        return $formattedData;
    }
}
