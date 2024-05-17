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

    }


}
