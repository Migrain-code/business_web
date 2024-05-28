<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Models\BussinessPackage;
use App\Models\PacketOrder;
use App\Services\E_Invoice;
use App\Services\Iyzico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class PaymentController extends Controller
{
    public function callback(Request $request, BussinessPackage $packet, BusinessOfficial $official)
    {
        Auth::guard('official')->loginUsingId($official->id);
        $user = authUser();

        $payment = (new Iyzico())->completePayment($request->paymentId);

        if ($payment->getStatus() == 'success') {
            $business =  $user->business;

            $packetOrder = new PacketOrder();
            $packetOrder->package_id = $packet->id;
            $packetOrder->business_id = $user->business->id;
            $packetOrder->price = $payment->getPrice();
            $packetOrder->tax = $request->kdv ?? 0;
            $packetOrder->discount = $request->discount ?? 0;
            $packetOrder->payment_id = $payment->getPaymentId();
            $packetOrder->payment_type = 'CARD';
            $packetOrder->status = 'PAYED';
            $packetOrder->save();
            $invoice = $this->createEInvoice($packetOrder);

            if ($invoice != false){
                $packetOrder->invoice_no = $invoice->guid;
                $packetOrder->invoice_url = $invoice->url;
            } else{
                $packetOrder->invoice_no = "FALSE";
            }
            $packetOrder->save();
            $business->package_id = $packet->id;
            $business->packet_start_date = now();
            $business->packet_end_date = now()->addDays($packet->type == 0 ? 30 : 365);
            $business->save();

            $user->setPermission($packet->id);
            return to_route('business.packet.payment.success', ['order-no' => $packetOrder->id]);
        }
        return to_route('business.packet.payment.fail');
    }

    public function createEInvoice($packetOrder)
    {
        $originalPrice = $packetOrder->price + $packetOrder->discount;
        $invoiceGenerator = new E_Invoice();
        $invoiceGenerator->createCustomer($packetOrder->business_id, $packetOrder->business->name, $packetOrder->business->address);
        $invoiceGenerator->createAmount($originalPrice, $packetOrder->discount);
        $invoiceGenerator->createProduct($packetOrder->package_id, $packetOrder->package->name. " Üyelik Paketi", $packetOrder->discount);
        $invoiceGenerator->createInvoice($packetOrder->id);
        $response = json_decode($invoiceGenerator->sendInvoice());

        if ($response->error == ""){
            return $response;
        } else{
            return false;
        }
    }
}
