<?php

namespace App\Services;

use Iyzipay\Model\Address;
use Iyzipay\Model\Buyer;
use Iyzipay\Model\PaymentCard;

class Iyzico
{
    private string $apiUrl = "https://sandbox-api.iyzipay.com";
    private string $apikey = 'sandbox-ySUSboVTBmQZqnu2r8RIMFdSfNbVzllx';
    private string $secretKey = 'sandbox-86h7NjkcNi8T6J3RQUUiw5raND4AdmSV';
    private string $conversationId = '';
    private float $price = 0;
    private string $callbackUrl = '';
    private PaymentCard $card;
    private Buyer $buyer;
    private Address $shippingAddress;
    private Address $billingAddress;
    private array $basketItems = [];

    public function createPaymentRequest()
    {
        $request = new \Iyzipay\Request\CreatePaymentRequest();

        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setConversationId($this->conversationId);
        $request->setPrice($this->price);
        $request->setPaidPrice($this->price);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);
        $request->setInstallment(1);
        $request->setBasketId($this->conversationId);
        $request->setPaymentChannel(\Iyzipay\Model\PaymentChannel::WEB);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl($this->callbackUrl);
        $request->setPaymentCard($this->getCard());
        $request->setBuyer($this->getBuyer());
        $request->setShippingAddress($this->getShippingAddress());
        $request->setBillingAddress($this->getBillingAddress());
        $request->setBasketItems($this->getBasketItems());
        return \Iyzipay\Model\ThreedsInitialize::create($request, $this->config());
    }

    public function completePayment($paymentId)
    {
        $request = new \Iyzipay\Request\CreateThreedsPaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setPaymentId($paymentId);

        return \Iyzipay\Model\ThreedsPayment::create($request, $this->config());
    }

    public function paymentDetails($paymentId): \Iyzipay\Model\Payment
    {
        $request = new \Iyzipay\Request\RetrievePaymentRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setPaymentId($paymentId);

        return \Iyzipay\Model\Payment::retrieve($request, $this->config());
    }

    public function config()
    {
        $options = new \Iyzipay\Options();
        $options->setApiKey($this->apikey);
        $options->setSecretKey($this->secretKey);
        $options->setBaseUrl($this->apiUrl);

        return $options;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    /**
     * @return string
     */
    public function getApikey(): string
    {
        return $this->apikey;
    }

    /**
     * @param string $apikey
     */
    public function setApikey(string $apikey): void
    {
        $this->apikey = $apikey;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey(string $secretKey): void
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getConversationId(): string
    {
        return $this->conversationId;
    }

    /**
     * @param string $conversationId
     */
    public function setConversationId(string $conversationId): void
    {
        $this->conversationId = $conversationId;
    }

    /**
     * @return float|int
     */
    public function getPrice(): float|int
    {
        return $this->price;
    }

    /**
     * @param float|int $price
     */
    public function setPrice(float|int $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCallbackUrl(): string
    {
        return $this->callbackUrl;
    }

    /**
     * @param string $callbackUrl
     */
    public function setCallbackUrl(string $callbackUrl): void
    {
        $this->callbackUrl = $callbackUrl;
    }

    /**
     * @return PaymentCard
     */
    public function getCard(): PaymentCard
    {
        return $this->card;
    }

    /**
     * @param PaymentCard $card
     */
    public function setCard($name, $cardNumber, $expireMonth, $expireYear, $cvc, $register = 0): void
    {
        $paymentCard = new \Iyzipay\Model\PaymentCard();
        $paymentCard->setCardHolderName($name);
        $paymentCard->setCardNumber($cardNumber);
        $paymentCard->setExpireMonth($expireMonth);
        $paymentCard->setExpireYear($expireYear);
        $paymentCard->setCvc($cvc);
        $paymentCard->setRegisterCard($register);

        $this->card = $paymentCard;
    }

    /**
     * @return Buyer
     */
    public function getBuyer(): Buyer
    {
        return $this->buyer;
    }

    /**
     * @param Buyer $buyer
     */
    public function setBuyer($id = null, $name = null, $surname = null, $phone = null, $email = null, $identity_number = '11111111111', $last_login_date = '2023-03-30 12:43:35', $register_date = '2023-03-30 12:43:35', $address = 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1', $ip = '192.168.1.1', $city = 'İstanbul', $country = 'Türkiye', $post_code = '34000'): void
    {
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($id);
        $buyer->setName($name);
        $buyer->setSurname($surname);
        $buyer->setGsmNumber($phone);
        $buyer->setEmail($email);
        $buyer->setIdentityNumber($identity_number);
        $buyer->setLastLoginDate($last_login_date);
        $buyer->setRegistrationDate($register_date);
        $buyer->setRegistrationAddress($address);
        $buyer->setIp($ip);
        $buyer->setCity($city);
        $buyer->setCountry($country);
        $buyer->setZipCode($post_code);

        $this->buyer = $buyer;
    }

    /**
     * @return Address
     */
    public function getShippingAddress(): Address
    {
        return $this->shippingAddress;
    }

    /**
     * @param Address $shippingAddress
     */
    public function setShippingAddress($name = 'Jane Doe', $city = 'Istanbul', $country = 'Turkey', $address = 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1', $zip_code = '34000'): void
    {
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($name);
        $shippingAddress->setCity($city);
        $shippingAddress->setCountry($country);
        $shippingAddress->setAddress($address);
        $shippingAddress->setZipCode($zip_code);
        $this->shippingAddress = $shippingAddress;
    }

    /**
     * @return Address
     */
    public function getBillingAddress(): Address
    {
        return $this->billingAddress;
    }

    /**
     * @param Address $billingAddress
     */
    public function setBillingAddress($name = 'Jane Doe', $city = 'Istanbul', $country = 'Turkey', $address = 'Nidakule Göztepe, Merdivenköy Mah. Bora Sok. No:1', $zip_code = '34000'): void
    {
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($name);
        $billingAddress->setCity($city);
        $billingAddress->setCountry($country);
        $billingAddress->setAddress($address);
        $billingAddress->setZipCode($zip_code);
        $this->billingAddress = $billingAddress;
    }

    /**
     * @return array
     */
    public function getBasketItems(): array
    {
        return $this->basketItems;
    }

    /**
     * @param array $basketItems
     */
    public function addBasketItem($id, $name, $category, $price): void
    {
        $basketItem = new \Iyzipay\Model\BasketItem();
        $basketItem->setId($id);
        $basketItem->setName($name);
        $basketItem->setCategory1($category);
        $basketItem->setCategory2($category);
        $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $basketItem->setPrice($price);
        $this->basketItems[] = $basketItem;
    }


}
