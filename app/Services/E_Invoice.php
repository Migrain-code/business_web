<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class E_Invoice
{
    private $apiUrl;
    private $merchantId;

    private $invoice = [];
    private $customer = [];

    private $amounts = [];

    private $product = [];

    public function __construct()
    {
        $this->apiUrl = "https://bizimhesap.com/api/b2b/addinvoice";
        $this->merchantId = "FA8262AB32D74AE3965964E1A70BD842";
    }

    public function sendInvoice()
    {
        $data_string = $this->invoice;
        /*$options = [
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            ],
            CURLOPT_SSL_VERIFYPEER => false
        ];
        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);*/

        return $data_string;
    }

    public function createInvoice($invoiceNo, $note = "asd")
    {
        $this->invoice = [
            'firmID' => $this->merchantId,
            'invoiceNo' => $invoiceNo,
            'invoiceType' => 3,
            'note' => $note,
            'dates' => [
                "invoiceDate" => Carbon::now()->toIso8601String(),
                "dueDate" => Carbon::now()->addDays(30)->toIso8601String(),
            ],
            'customers' => $this->customer,
            'amounts' => $this->amounts,
            'details' => $this->product,
        ];
    }

    public function createCustomer($customerId, $customerName, $address, $taxOffice = null, $taxNo = null, $email = null, $phone = null) :void
    {
        $customer = [
            'customerId' => $customerId,
            'title' => $customerName,
            /*'taxOffice' => $taxOffice, //optional
            'taxNo' => $taxNo, //optional
            'email' => $email, //optional
            'phone' => $phone, //optional*/
            'address' => $address,
        ];

        $this->customer = $customer;
    }

    public function createAmount($invoicePrice)
    {
        $taxPrice = ($invoicePrice * 20) / 100;
        $netTotal = $invoicePrice - $taxPrice;

        $this->amounts = [
            "currency" => "TL",
            "gross" => number_format($netTotal, 2),
            "discount" => "0.00",
            "net" => number_format($netTotal, 2),
            "tax" => number_format($taxPrice, 2),
            "total" => $invoicePrice,
        ];
    }

    public function createProduct($productId, $productName)
    {
        $this->product[] = [
            "productId" => $productId,
            "productName" => $productName,
            "taxRate" => "18.00",
            "quantity" => 1,
            "unitPrice" => $this->amounts["net"],
            "grossPrice" => $this->amounts["gross"],
            "discount" => "0.00",
            "net" => $this->amounts["net"],
            "tax" => $this->amounts["tax"],
            "total" => $this->amounts["total"]
        ];
    }
}
