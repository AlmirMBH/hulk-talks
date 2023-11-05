<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

trait InvoiceHelperFinalTrait
{
    private function formatBanner(Model $banner): array
    {
        return [
            $banner->getAttribute('title'),
            $banner->getAttribute('description'),
            $banner->getAttribute('template')
        ];
    }

    private function formatInvoiceDetails(Model $invoice, mixed $outstandingAmount = 0): array
    {
        return [
            $invoice->getAttribute('customer'),
            $invoice->getAttribute('invoice_number'),
            $invoice->getAttribute('total_amount'),
            $invoice->getAttribute('paid_installments_amount'),
            $outstandingAmount,
            $invoice->getAttribute('created_at')
        ];
    }

    private function calculateOutstandingInvoiceAmount(Model $invoice): int|float
    {
        $outstandingAmount = 0;

        if ($invoice->getAttribute('total_amount') !== $invoice->getAttribute('paid_installments_amount')) {
            $discount = $invoice->getAttribute('discount') ?? 0;

            $outstanding = ($invoice->getAttribute('total_amount') - $invoice->getAttribute('paid_installments_amount')) / 100 - $discount;

            $bonus = ($invoice->getAttribute('paid_installments_amount') / 100) > $invoice->getAttribute('min_bonus_amount')
                ? $invoice->getAttribute('bonus_plus')
                : $invoice->getAttribute('basic_bonus');

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
