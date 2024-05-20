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
        $data_string = json_encode($this->invoice);
        $options = [
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
        curl_close($ch);

        return $content;
    }

    public function createInvoice($invoiceNo, $note = "")
    {
        $this->invoice = [
            "firmId" => $this->merchantId,
            "invoiceNo" => $invoiceNo,
            "invoiceType" => 3,
            "note" => $note,
            "dates" => [
                "invoiceDate" => Carbon::now(),
                "dueDate" => Carbon::now()->addDays(30),
            ],
            "shipmentInfo" => [
                "shipmentNo" => "",
                "shipmentCompany" => ""
            ],
            "customer" => $this->customer,
            "amounts" => $this->amounts,
            "details" => $this->product,
        ];
    }

    public function createCustomer($customerId, $customerName, $address, $taxOffice = '', $taxNo = '', $email = '', $phone = '') :void
    {
        $this->customer = [
            'customerId' => $customerId,
            'title' => $customerName,
            'taxOffice' => $taxOffice, //optional
            'taxNo' => $taxNo, //optional
            'email' => $email, //optional
            'phone' => $phone, //optional
            'address' => $address,
        ];

    }

    public function createAmount($invoicePrice, $discount)
    {
        $taxPrice = ($invoicePrice * 20) / 100;
        $netTotal = $invoicePrice - $taxPrice;

        $this->amounts = [
            "currency" => "TL",
            "gross" => $netTotal,
            "discount" => $discount,
            "net" => $netTotal,
            "tax" => $taxPrice,
            "total" => $invoicePrice - $discount,
        ];

    }

    public function createProduct($productId, $productName, $discount = 0)
    {
        $this->product[] = [
            "productId" => $productId,
            "productName" => $productName,
            "taxRate" => 20,
            "quantity" => 1,
            "unitPrice" => $this->amounts["net"],
            "grossPrice" => $this->amounts["gross"],
            "discount" => $discount,
            "net" => $this->amounts["net"],
            "tax" => $this->amounts["tax"],
            "total" => $this->amounts["net"] + $this->amounts["tax"]
        ];

    }
}
