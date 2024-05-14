<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Models\BussinessPackage;
use App\Models\PacketOrder;
use App\Services\Iyzico;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacketOrderController extends Controller
{
    private $business;
    private $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
            return $next($request);
        });
    }
    public function index()
    {
        $packages = BussinessPackage::all();
        return view('business.package.index', compact('packages'));
    }
    public function buy(BussinessPackage $packet)
    {
        $prices = $packet->price;

        return view('business.package.payment.form', compact('packet', 'prices'));
    }
    public function pay(Request $request, BussinessPackage $packet)
    {

        //$request->dd();

        $count = 1;
        $kdv = 20;
        $amount = $packet->price;

        if ($request->paymentType == 'BANK_TRANSFER') {
            $packetOrder = new PacketOrder();
            $packetOrder->packet_id = $packet->id;
            $packetOrder->business_id = $this->business->id;
            $packetOrder->price = $amount;
            $packetOrder->tax = $prices['kdv'] ?? 0;
            $packetOrder->discount = $prices['discount'] ?? 0;
            $packetOrder->payment_id = 0;
            $packetOrder->payment_type = 'BANK_TRANSFER';
            $packetOrder->status = 'PENDING';
            $packetOrder->save();

            return to_route('business.packet.payment.success', ['odeme' => 'havale', 'siparis-no' => $packetOrder->id]);
        }

        $parts = explode(' ', $request->card_name);

        $surname = array_pop($parts);
        $name = implode(' ', $parts);


        $month = $request->card_expiry_month;
        $year = $request->card_expiry_year;


        $payment = new \App\Services\Iyzico();
        $payment->setConversationId(rand());
        $payment->setPrice($amount);
        $payment->setCallbackUrl(route('business.packet.payment.callback', [$packet->id, authUser()->id]) . '?count=' . $count . '&kdv=' . $kdv);
        $payment->setCard($request->card_name,
            str($request->card_number)->replace(' ', '')
            , $month,
            $year,
            $request->card_cvv);
        $payment->setBuyer(authUser()->id, $name, $surname, authUser()->phone, authUser()->email);
        $payment->setShippingAddress();
        $payment->setBillingAddress();
        $payment->addBasketItem($packet->id, $packet->name, 'Paket', $amount);
        $response = $payment->createPaymentRequest();

        if ($response->getStatus() == 'failure') {
            $request->flash();
            return back()->with('response', [
                'status' => 'error',
                'message' => $response->getErrorMessage()
            ]);
        }

        echo $response->getHtmlContent();
    }


    public function success()
    {
        return view('business.package.payment.success');
    }

    public function fail()
    {
        return view('business.package.payment.failed');
    }
}
