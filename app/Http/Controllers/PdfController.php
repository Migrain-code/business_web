<?php

namespace App\Http\Controllers;

use App\Models\PacketOrder;
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
        return response()->json([
            'OrderStatus' => [
                "Id" => 1,
                "Value" => "Onaylandı"
            ],
            [
                "Id" => 2,
                "Value" => "Kargolandı"
            ],
            [
                "Id" => 3,
                "Value" => "İptal Edildi"
            ]
        ]);
    }
}
