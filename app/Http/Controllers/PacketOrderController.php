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

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
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


        $parts = explode(' ', $request->card_name);

        $surname = array_pop($parts);
        $name = implode(' ', $parts);

        $month = $request->card_expiry_month;
        $year = $request->card_expiry_year;

        $payment = new \App\Services\Iyzico();

        $options = new \Iyzipay\Options();
        $options->setApiKey("sandbox-ySUSboVTBmQZqnu2r8RIMFdSfNbVzllx");
        $options->setSecretKey("sandbox-86h7NjkcNi8T6J3RQUUiw5raND4AdmSV");
        $options->setBaseUrl("https://sandbox-api.iyzipay.com");

        $newRequest = new \Iyzipay\Request\CreatePaymentRequest();
        $newRequest->setLocale(\Iyzipay\Model\Locale::TR);
        $newRequest->setConversationId("123456789");
        $newRequest->setPrice("1");
        $newRequest->setPaidPrice("1.2");
        $newRequest->setCurrency(\Iyzipay\Model\Currency::TL);
        $newRequest->setInstallment(1);
        $newRequest->setBasketId("B67832");
        $newRequest->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $newRequest->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName("John Doe");
        $paymentCard->setCardNumber("5528790000000008");
        $paymentCard->setExpireMonth("12");
        $paymentCard->setExpireYear("2030");
        $paymentCard->setCvc("123");
        $paymentCard->setRegisterCard(0);
        $newRequest->setPaymentCard($paymentCard);

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName("John");
        $buyer->setSurname("Doe");
        $buyer->setGsmNumber("+905350000000");
        $buyer->setEmail("email@email.com");
        $buyer->setIdentityNumber("74300864791");
        $buyer->setLastLoginDate("2015-10-05 12:43:35");
        $buyer->setRegistrationDate("2013-04-21 15:12:09");
        $buyer->setRegistrationAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $buyer->setIp("85.34.78.112");
        $buyer->setCity("Istanbul");
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("34732");
        $newRequest->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName("Jane Doe");
        $shippingAddress->setCity("Istanbul");
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $shippingAddress->setZipCode("34742");
        $newRequest->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName("Jane Doe");
        $billingAddress->setCity("Istanbul");
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress("Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1");
        $billingAddress->setZipCode("34742");
        $newRequest->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BI101");
        $firstBasketItem->setName("Binocular");
        $firstBasketItem->setCategory1("Collectibles");
        $firstBasketItem->setCategory2("Accessories");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice("0.3");
        $basketItems[0] = $firstBasketItem;

        $secondBasketItem = new \Iyzipay\Model\BasketItem();
        $secondBasketItem->setId("BI102");
        $secondBasketItem->setName("Game code");
        $secondBasketItem->setCategory1("Game");
        $secondBasketItem->setCategory2("Online Game Items");
        $secondBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $secondBasketItem->setPrice("0.5");
        $basketItems[1] = $secondBasketItem;

        $thirdBasketItem = new \Iyzipay\Model\BasketItem();
        $thirdBasketItem->setId("BI103");
        $thirdBasketItem->setName("Usb");
        $thirdBasketItem->setCategory1("Electronics");
        $thirdBasketItem->setCategory2("Usb / Cable");
        $thirdBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $thirdBasketItem->setPrice("0.2");
        $basketItems[2] = $thirdBasketItem;
        $newRequest->setBasketItems($basketItems);

        $payment = \Iyzipay\Model\Payment::create($newRequest, $options);
        dd($payment);
        /*if ($response->getStatus() == 'failure') {
            $request->flash();
            return back()->with('response', [
                'status' => 'error',
                'message' => $response->getErrorMessage()
            ]);
        }*/

        echo $response->getHtmlContent();
    }

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

    public function success()
    {
        return view('company.packet.payment.success');
    }

    public function fail()
    {
        return view('company.packet.payment.fail');
    }
}
