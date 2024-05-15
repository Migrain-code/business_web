<?php

namespace App\Http\Controllers;

use App\Models\PacketOrder;
use App\Services\E_Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf(PacketOrder $invoice)
    {
        $business = authUser()->business;
        $pdf = Pdf::loadView('business.invoice.edit.index', compact('invoice', 'business'));
        $content = $pdf->output();
        return response()->setContent($content);
    }

    public function getOrderStatus()
    {
        $invoiceGenerator = new E_Invoice();
        $invoiceGenerator->createCustomer('1', 'Muhammet', 'asd');
        $invoiceGenerator->createAmount(15);
        $invoiceGenerator->createProduct("2", 'Pro Paket');
        $invoiceGenerator->createInvoice('1', 'Test');
        $response = $invoiceGenerator->sendInvoice();
        return response()->json($response);
    }
}
