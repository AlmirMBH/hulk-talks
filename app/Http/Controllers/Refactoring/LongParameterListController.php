<?php

namespace App\Http\Controllers\Refactoring;

use App\Helpers\LongParameterListTrait;
use App\Http\Controllers\Controller;
use App\ValueObjects\Refactoring\InvoiceValueObject;

/**
 * LONG PARAMETER LIST
 */
class LongParameterListController extends Controller
{
    use LongParameterListTrait;


    /**
     * SEND DATA AS PRIMITIVE DATA TYPES (MULTIPLE PARAMETERS)
     * (pros: data is validated, cons: can be hard to read and debug)
     */
    public function printInvoice(int $invoiceId, int $printOutstandingAmount): array
    {
        return $this->formatOutputData(
            $this->getBanner($invoiceId),
            $this->getInvoiceDetails($invoiceId, $this->calculateOutstandingInvoiceAmount($invoiceId)),
            (bool) $printOutstandingAmount
         );
    }

    private function formatOutputData(array $banner, array $invoiceDetails, ?bool $printOutstandingAmount = false): array
    {
        return [
            'title' => $banner[0],
            'description' => $banner[1],
            'template' => $banner[2],
            'customer' => $invoiceDetails[0],
            'invoiceNumber' => $invoiceDetails[1],
            'totalAmount' => $invoiceDetails[2],
            'paidInstallmentsAmount' => $invoiceDetails[3],
            ...$this->validateOutstanding($invoiceDetails[4], $printOutstandingAmount),
            'invoiceDate' => $invoiceDetails[5]
        ];
    }



    /**
     * SEND DATA AS AN ARRAY
     * (pros: easy to read, cons: data is not validated)
     */
    public function printInvoiceArray(int $invoiceId, int $printOutstandingAmount): array
    {
        $data = [
            ...$this->getBanner($invoiceId),
            ...$this->getInvoiceDetails($invoiceId, $this->calculateOutstandingInvoiceAmount($invoiceId)),
            (bool) $printOutstandingAmount
        ];

        return $this->formatOutputDataUsingArray($data);
    }

    private function formatOutputDataUsingArray(array $data): array
    {
        return [
            'title' => $data[0],
            'description' => $data[1],
            'template' => $data[2],
            'customer' => $data[3],
            'invoiceNumber' => $data[4],
            'totalAmount' => $data[5],
            'paidInstallmentsAmount' => $data[6],
            ...$this->validateOutstanding($data[7], $data[9]),
            'invoiceDate' => $data[8],
        ];
    }



    /**
     * SEND DATA AS AN OBJECT
     * (pros: easy to read (descriptive variables), named parameters, data is validated/encapsulated, cons: more code)
     */
    public function printInvoiceValueObject(int $invoiceId, int $printOutstandingAmount): array
    {
        [
            $bannerTitle,
            $bannerDescription,
            $bannerTemplate
        ] = $this->getBanner($invoiceId);

        [
            $customer,
            $invoiceNumber,
            $totalAmount,
            $invoicePaidInstallmentsAmount,
            $outstandingAmount,
            $invoiceDate
        ] = $this->getInvoiceDetails($invoiceId, $this->calculateOutstandingInvoiceAmount($invoiceId));

        $data = new InvoiceValueObject(
            customer: $customer,
            invoiceNumber: $invoiceNumber,
            totalAmount: $totalAmount,
            invoicePaidInstallmentsAmount: $invoicePaidInstallmentsAmount,
            invoiceDate: $invoiceDate,
            printOutstandingAmount: (bool) $printOutstandingAmount,
            outstandingAmount: $outstandingAmount,
            bannerTitle: $bannerTitle,
            bannerDescription: $bannerDescription,
            bannerTemplate: $bannerTemplate
        );

        return $this->formatOutputDataUsingValueObject($data);
    }

    private function formatOutputDataUsingValueObject(InvoiceValueObject $invoiceValueObject): array
    {
        return [
            'title' => $invoiceValueObject->getBannerTitle(),
            'description' => $invoiceValueObject->getBannerDescription(),
            'template' => $invoiceValueObject->getBannerTemplate(),
            'customer' => $invoiceValueObject->getCustomer(),
            'invoiceNumber' => $invoiceValueObject->getInvoiceNumber(),
            'totalAmount' => $invoiceValueObject->getTotalAmount(),
            'paidInstallmentsAmount' => $invoiceValueObject->getInvoicePaidInstallmentsAmount(),
            ...$this->validateOutstanding($invoiceValueObject, $invoiceValueObject->getPrintOutstandingAmount()),
            'invoiceDate' => $invoiceValueObject->getInvoiceCreatedAt(),
        ];
    }
}
