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
        $newRequest->setConversationId(rand(1, 100000));
        $newRequest->setPrice($packet->price);
        $newRequest->setPaidPrice($packet->price);
        $newRequest->setCurrency(\Iyzipay\Model\Currency::TL);
        $newRequest->setInstallment(1);
        //$newRequest->setCallbackUrl(route('business.packet.payment.callback'));
        $newRequest->setBasketId("BP".rand(1, 10000));
        $newRequest->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $newRequest->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);

        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($request->input('card_name'));
        $paymentCard->setCardNumber($request->input('card_number'));
        $paymentCard->setExpireMonth("12");
        $paymentCard->setExpireYear("2030");
        $paymentCard->setCvc("123");
        $paymentCard->setRegisterCard(0);
        $newRequest->setPaymentCard($paymentCard);

        $name = explode(' ', $this->user->name);
        $user = $this->user;
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BO". authUser()->id);
        $buyer->setName($name[0]);
        $buyer->setSurname($name[1]);
        $buyer->setGsmNumber($user->phone);
        $buyer->setEmail($user->email);
        $buyer->setIdentityNumber("11111111111");
        $buyer->setLastLoginDate(now()->format('Y-m-d H:i:s'));
        $buyer->setRegistrationDate($user->created_at->format('Y-m-d H:i:s'));
        $buyer->setRegistrationAddress($this->business->address);
        $buyer->setIp($request->ip());
        $buyer->setCity($this->business->cities->name);
        $buyer->setCountry("Turkey");
        $newRequest->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($user->name);
        $shippingAddress->setCity($this->business->cities->name);
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress($this->business->address);
        $newRequest->setShippingAddress($shippingAddress);

        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($user->name);
        $billingAddress->setCity($this->business->cities->name);
        $billingAddress->setCountry("Turkey");
        $billingAddress->setAddress($this->business->address);
        $newRequest->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("BP". rand(1, 10000));
        $firstBasketItem->setName($packet->name);
        $firstBasketItem->setCategory1("Paketler");
        $firstBasketItem->setCategory2("Hizmet Paketleri");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $firstBasketItem->setPrice($packet->price);
        $basketItems[0] = $firstBasketItem;

        $newRequest->setBasketItems($basketItems);

        $response = \Iyzipay\Model\Payment::create($newRequest, $options);

        if ($response->getStatus() == 'failure') {
            $request->flash();
            return back()->with('response', [
                'status' => 'error',
                'message' => $response->getErrorMessage()
            ]);
        }

        echo $response->getHtmlContent();
    }

    public function callback(Request $request)
    {
        //Auth::guard('official')->loginUsingId($official->id);
        $request->dd();
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
