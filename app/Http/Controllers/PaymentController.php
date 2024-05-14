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

            $business->package_id = $packet->id;
            $business->packet_start_date = now();
            $business->packet_end_date = now()->addDays($packet->type == 0 ? 30 : 365);
            $business->save();
            //$this->createInvoice($packetOrder->id, $packetOrder->price - $packetOrder->tax, $packet->id = 43841443, $company->getParachuteId());

            return to_route('business.packet.payment.success', ['order-no' => $packetOrder->id]);
        }
        return to_route('business.packet.payment.fail');
    }

}
