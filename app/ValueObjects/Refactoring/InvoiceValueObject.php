<?php

namespace App\ValueObjects\Refactoring;

use Illuminate\Database\Eloquent\Model;

class InvoiceValueObject
{
    public function __construct(
        private readonly ?string $customer = null,
        private readonly ?string $invoiceNumber = null,
        private readonly ?float $totalAmount = null,
        private readonly ?float $invoicePaidInstallmentsAmount = null,
        private readonly ?string $invoiceDate = null,
        private readonly ?bool $printOutstandingAmount = false,
        private readonly int|float $outstandingAmount = 0,
        private readonly ?string $bannerTitle = null,
        private readonly ?string $bannerDescription = null,
        private readonly ?string $bannerTemplate = null
    )
    {
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function getInvoicePaidInstallmentsAmount(): ?float
    {
        return $this->invoicePaidInstallmentsAmount;
    }

    public function getInvoiceCreatedAt(): ?string
    {
        return $this->invoiceDate;
    }

    public function getPrintOutstandingAmount(): ?bool
    {
        return $this->printOutstandingAmount;
    }

    public function getOutstandingAmount(): float|int|null
    {
        return $this->outstandingAmount;
    }

    public function getBannerTitle(): ?string
    {
        return $this->bannerTitle;
    }

    public function getBannerDescription(): ?string
    {
        return $this->bannerDescription;
    }

    public function getBannerTemplate(): ?string
    {
        return $this->bannerTemplate;
    }
}
