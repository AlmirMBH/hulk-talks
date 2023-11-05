<?php

namespace App\Http\Controllers\Refactoring;

use App\Helpers\LongParameterListTrait;
use App\Http\Controllers\Controller;
use App\ValueObjects\Refactoring\InvoiceValueObject;

/**
 * LONG PARAMETER LIST
 * In our early programming days, we were taught to pass in as parameters everything needed by a function. This was understandable because the alternative
 * was global data, and global data quickly becomes evil. But long parameter lists are often confusing in their own right. If you can obtain one parameter
 * by asking another parameter for it, you can use Replace Parameter with Query (324) to remove the second parameter. Rather than pulling lots of data out
 * of an existing data structure, you can use Preserve Whole Object (319) to pass the original data structure instead. If several parameters always fit
 * together, combine them with Introduce Parameter Object (140). If a parameter is used as a flag to dispatch different behavior, use Remove Flag Argument
 * (314). Classes are a great way to reduce parameter list sizes. They are particularly useful when multiple functions share several parameter values. Then,
 * you can use Combine Functions into Class (144) to capture those common values as fields. If we put on our functional programming hats, we’d say this
 * creates a set of partially applied functions.
 */
class LongParameterListController extends Controller
{
    use LongParameterListTrait;


    /**
     * Parameters
     */
    public function printInvoice(int $invoiceId, int $printOutstandingAmount): array
    {
        return $this->formatOutputData(
            banner: $this->getBanner($invoiceId),
            invoiceDetails: $this->getInvoiceDetails(
                invoiceId: $invoiceId,
                outstandingAmount: $this->calculateOutstandingInvoiceAmount($invoiceId)
            ),
            printOutstandingAmount: (bool) $printOutstandingAmount
         );
    }

    /**
     * Array
     */
    public function printInvoiceArray(int $invoiceId, int $printOutstandingAmount): array
    {
        $data = [
            $this->getBanner($invoiceId),
            $this->getInvoiceDetails($invoiceId, $this->calculateOutstandingInvoiceAmount($invoiceId)),
            (bool) $printOutstandingAmount
        ];

        return $this->formatOutputDataUsingArray($data);
    }

    /**
     * Value object
     */
    public function printInvoiceValueObject(int $invoiceId, int $printOutstandingAmount): array
    {
        [$bannerTitle, $bannerDescription, $bannerTemplate]
            = $this->getBanner($invoiceId);

        [$customer, $invoiceNumber, $totalAmount, $invoicePaidInstallmentsAmount, $outstandingAmount, $invoiceDate]
            = $this->getInvoiceDetails($invoiceId, $this->calculateOutstandingInvoiceAmount($invoiceId));

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


    /**
     * Methods below should be in the trait; left here for the presentation purposes
     */
    private function formatOutputData(array $banner, array $invoiceDetails, ?bool $printOutstandingAmount = false): array
    {
        $data = array_merge($banner, $invoiceDetails);

        return [
            'title' => $data[0],
            'description' => $data[1],
            'template' => $data[2],
            'customer' => $data[3],
            'invoiceNumber' => $data[4],
            'totalAmount' => $data[5],
            'paidInstallmentsAmount' => $data[6],
            ...$this->validateOutstanding($data, $printOutstandingAmount),
            'invoiceDate' => $data[8]
        ];
    }

    private function formatOutputDataUsingArray(array $data): array
    {
        [$banner, $invoiceDetails, $printOutstandingAmount] = $data;

        return [
            'title' => $banner[0],
            'description' => $banner[1],
            'template' => $banner[2],
            'customer' => $invoiceDetails[0],
            'invoiceNumber' => $invoiceDetails[1],
            'totalAmount' => $invoiceDetails[2],
            'paidInstallmentsAmount' => $invoiceDetails[3],
            ...$this->validateOutstanding($invoiceDetails, $printOutstandingAmount),
            'invoiceDate' => $invoiceDetails[5],
        ];
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
