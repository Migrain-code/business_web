<?php

namespace App\Http\Controllers;

use App\Models\PacketOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class InvoiceController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('business.invoice.index');
    }

    public function show(PacketOrder $invoice)
    {
        $business = $this->business;
        return view('business.invoice.edit.index', compact('invoice', 'business'));
    }
    public function datatable()
    {
        $invoices = $this->business->invoices;

        return DataTables::of($invoices)
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->editColumn('price', function ($q) {
                $taxPrice = ($q->package->price * 20) / 100;
                $calculatePrice = $q->package->price - $taxPrice;
                return formatPrice($calculatePrice);
            })
            ->editColumn('tax', function ($q) {
                return $q->tax. "%";
            })
            ->addColumn('total', function ($q) {
                $taxPrice = ($q->package->price * 20) / 100;
                $calculatePrice = $q->package->price - $taxPrice;
                return formatPrice($calculatePrice + $taxPrice);
            })
            ->editColumn('invoice_no', function ($q){
                return create_info_button($q->invoice_url, Str::limit($q->invoice_no, 20));
            })
            ->addColumn('status', function ($q){
                if ($q->status != "PAYED"){
                    return html()->span()->class('badge badge-light-danger')->text("Ödeme Yapılmadı");
                } else{
                    return html()->span()->class('badge badge-light-success')->text("Ödeme Başarılı");
                }
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_show_button(route('business.invoice.show', $q->id));

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
