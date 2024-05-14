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
        $kdv = "20";
        $amount = $packet->price;

        $parts = explode(' ', $request->card_name);

        $surname = array_pop($parts);
        $name = implode(' ', $parts);


        $month = $request->card_expiry_month;
        $year = $request->card_expiry_year;


        $payment = new \App\Services\Iyzico();
        $payment->setConversationId(rand());
        $payment->setPrice($amount);
        $payment->setCallbackUrl(route('business.packet.payment.callback', [$packet->id, authUser()->id]) . '?count=' . $count . '&kdv=' . $kdv);
        $payment->setCard('John Doe','5528790000000008','12','2030', '123');
        $payment->setBuyer('1',
            'Muhammet',
            'Türkmen', '5537021355',
            'muhammetturkmenn52@gmail.com',
            rand(),
            now()->format('Y-m-d H:i:s'),
            now()->subDays(5)->format('Y-m-d H:i:s'),
        );
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
