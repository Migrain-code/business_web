<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Models\BussinessPackage;
use App\Models\PacketOrder;
use App\Services\Iyzico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function callback(Request $request, BussinessPackage $packet, BusinessOfficial $official)
    {
        Auth::guard('official')->loginUsingId($official->id);

        $payment = (new Iyzico())->completePayment($request->paymentId);

        if ($payment->getStatus() == 'success') {

            $packetOrder = new PacketOrder();
            $packetOrder->packet_id = $packet->id;
            $packetOrder->company_id = $this->business->id;
            $packetOrder->price = $payment->getPrice();
            $packetOrder->tax = $request->kdv ?? 0;
            $packetOrder->discount = $request->discount ?? 0;
            $packetOrder->payment_id = $payment->getPaymentId();
            $packetOrder->payment_type = 'CARD';
            $packetOrder->save();

            $business = Business::find(authUser()->business->id);

            //$this->createInvoice($packetOrder->id, $packetOrder->price - $packetOrder->tax, $packet->id = 43841443, $company->getParachuteId());

            return to_route('business.packet.payment.success', ['siparis-no' => $packetOrder->id]);
        }
        return to_route('business.packet.payment.fail');
    }

}
