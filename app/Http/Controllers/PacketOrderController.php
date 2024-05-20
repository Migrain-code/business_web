<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Models\BussinessPackage;
use App\Models\Coupon;
use App\Models\CouponOfficial;
use App\Models\PacketOrder;
use App\Services\E_Invoice;
use App\Services\Iyzico;
use App\Services\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $monthlyPackages = BussinessPackage::where('type', 0)->where('price', '>', 0)->orderBy('price', 'asc')->get();
        $yearlyPackages = BussinessPackage::where('type', 1)->where('price', '>', 0)->orderBy('price', 'asc')->get();
        return view('business.package.index', compact('monthlyPackages', 'yearlyPackages'));
    }

    public function buy(BussinessPackage $packet)
    {
        $discountTotal = 0;
        $discountRate = 0;
        $prices = $packet->price;
        $coupon = Session::get('coupon');
        if (isset($coupon)){
            $discountTotal = ceil( ($packet->price * $coupon->discount) / 100);
            $discountRate = $coupon->discount;
        }
        $generalTotal = $packet->price - (($packet->price * 20) / 100);
        $taxTotal = ($packet->price * 20) / 100;
        $total = $packet->price - $discountTotal;

        return view('business.package.payment.form', compact('packet', 'prices', 'generalTotal', 'taxTotal', 'discountTotal', 'total', 'discountRate'));
    }
    public function useCoupon(Request $request, BussinessPackage $packet)
    {
        //$request->dd();
        $findCoupon = Coupon::where('code', $request->input('coupon_code'))->whereStatus(1)->first();
        if ($findCoupon){
            $findCouponOfficial = CouponOfficial::where('coupon_id', $findCoupon->id)
                ->where('official_id', authUser()->id)
                ->first();
            if ($findCouponOfficial){
                if ($findCouponOfficial->status == 0){
                    Session::put('coupon', $findCoupon);
                    $findCouponOfficial->status = 1;
                    $findCouponOfficial->save();
                    if ($findCoupon->discount == 100){
                        $business = $this->business;
                        $business->package_id = $packet->id;
                        $business->packet_start_date = now();
                        $business->packet_end_date = now()->addDays($packet->type == 0 ? 30 : 365);
                        Session::forget('coupon');
                        return to_route('business.home')->with('response', [
                            'status' => "success",
                            'message' => "Kupon Kodundan 100% indirim aldınız. Paket Sisteminize Otomatik Tanımlandı."
                        ]);
                    }
                    return back()->with('response', [
                        'status' => "success",
                        'message' => "Kupon Kodu Uygulandı"
                    ]);
                } else{
                    return back()->with('response', [
                        'status' => "error",
                        'message' => "Kupon Kodunu Daha Önce Kullandınız"
                    ]);
                }
            } else{
                return back()->with('response', [
                    'status' => "error",
                    'message' => "Kupon Kodu Bulunamadı"
                ]);
            }

        } else{
            return back()->with('response', [
               'status' => "error",
               'message' => "Kupon Kodu Bulunamadı"
            ]);
        }
    }

    public function removeCoupon(Request $request, BussinessPackage $packet)
    {
        $findCoupon = Session::get('coupon');
        $findCouponOfficial = CouponOfficial::where('coupon_id', $findCoupon->id)
            ->where('official_id', authUser()->id)
            ->first();
        if($findCouponOfficial){
            $findCouponOfficial->status = 0;
            $findCouponOfficial->save();
            Session::forget('coupon');
        }
        return back()->with('response', [
            'status' => "success",
            'message' => "Kupon Kodu Kaldırıldı."
        ]);
    }
    public function pay(Request $request, BussinessPackage $packet)
    {

        //$request->dd();
        $discountTotal = 0;
        $discountRate = 0;
        $count = 1;
        $kdv = 20;
        $amount = $packet->price;
        $coupon = Session::get('coupon');
        if (isset($coupon)){
            $discountTotal = ceil(($coupon->discount * $packet->price) / 100);
            $discountRate = $coupon->discount;
            $amount = $packet->price - $discountTotal;
        }
        $parts = explode(' ', $request->card_name);

        $surname = array_pop($parts);
        $name = implode(' ', $parts);

        $month = $request->card_expiry_month;
        $year = $request->card_expiry_year;

        $payment = new \App\Services\Iyzico();
        $payment->setConversationId(rand(1000, 10000000000));
        $payment->setPrice($amount);
        $payment->setCallbackUrl(route('business.packet.payment.callback', [$packet->id, authUser()->id]) . '?count=' . $count . '&kdv=' . $kdv . '&discount=' . $discountTotal);
        $payment->setCard($request->card_name,
            str(clearNumber($request->card_number))->replace(' ', '')
            , $month,
            $year,
            clearNumber($request->card_cvv));
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


    public function success(Request $request)
    {
        $order = PacketOrder::find($request->input('order-no'));

        if ($order) {
            $taxPrice = ($order->package->price * 20) / 100;
            $generalTotal = $order->package->price - $taxPrice;
            $total = ($generalTotal + $taxPrice) - $order->discount;
            $discountTotal = $order->discount;
            return view('business.package.payment.success', compact('order', 'generalTotal', 'taxPrice', 'total', 'discountTotal'));
        } else {
            return to_route('business.home')->with('response', [
                'status' => 'error',
                'message' => "Sipariş Bilgisi Bulunamadı"
            ]);
        }

    }

    public function fail()
    {
        return view('business.package.payment.failed');
    }
}
