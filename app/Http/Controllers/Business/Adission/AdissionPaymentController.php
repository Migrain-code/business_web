<?php

namespace App\Http\Controllers\Business\Adission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adission\AdissionSaveRequest;
use App\Http\Requests\Adission\PaymentAddRequest;
use App\Http\Resources\Adission\AdissionDetailResoruce;
use App\Http\Resources\Adission\AdissionPaymentListResoruce;
use App\Models\Appointment;
use App\Models\AppointmentCollectionEntry;
use App\Models\RemainingPayment;

/**
 * @group Adisyonlar
 *
 */
class AdissionPaymentController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    /**
     * Adisyon Ödeme Detayı
     *
     * Bu apide dönen response <b>isPermission</b> true olarak gelmiş ise parapuan yükleme alanı görünecek.
     * Oradan da kayıt apisine <b>isPoint</b> true veya false zorunlu olarak gönderilecek. default olarak false alınacak
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Appointment $adission)
    {
        return response()->json(AdissionDetailResoruce::make($adission));
    }

    /**
     * Adisyon Ödeme Oluşturma
     *
     * Ödeme Tipleri bu apiden dönecek
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Appointment $adission)
    {
        $paymentTypes = [
            0 => ["id" => 0, "name" => "Nakit"],
            1 => ["id" => 1, "name" => "Banka / Kredi Kartı"],
            2 => ["id" => 2, "name" => "EFT / Havale"],
            3 => ["id" => 3, "name" => "Diğer"],
        ];

        return response()->json([
            'payment_types' => $paymentTypes,
        ]);
    }

    /**
     * Adisyon Ödeme Ekleme
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PaymentAddRequest $request, Appointment $adission)
    {
        if ($adission->remainingTotal() == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu Adisyonda tüm ücretler tahsil edildi. Başka Tahsilat Ekleyemezsiniz."
            ]);
        }
        if($request->price > $adission->remainingTotal()){
            return response()->json([
               'status' => "error",
               'message' => "Adisyonda tahsil edilecek tutar ". $adission->remainingTotal(). " TL'dir. Bu ücretten daha yüksek bir ücret giremezsiniz",
               'price' => $adission->remainingTotal()
            ]);
        }
        //$request->dd();

        $adissionEarnedPoint = $this->saveAppointmentEarnedPoint($request, $adission);
        if ($adissionEarnedPoint){
            $appointmentCollection = new AppointmentCollectionEntry();
            $appointmentCollection->appointment_id = $adission->id;
            $appointmentCollection->payment_type_id = $request->paymentType;
            $appointmentCollection->price = $request->price;
            $appointmentCollection->save();
            $adission->status = 5;
            $adission->save();
            foreach ($adission->services as $service){
                $service->status = 5;
                $service->save();
            }
            return response()->json([
                'status' => "success",
                'message' => "Tahsilat Başarılı Bir Şekilde Eklendi"
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Hata! Ödeme Yöntemi Bulunamadı"
        ]);
    }
    /**
     * Adisyon Ödeme Kayıt Apisi
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function paymentSave(AdissionSaveRequest $request, Appointment $adission)
    {
        if ($adission->remainingTotal() == 0){
            if ($request->isPoint){ //parapuan yükleme aktif ise
                if ($adission->addCashPoint()){
                    return response()->json([
                        'status' => "success",
                        'message' => "Parapuan başarılı bir şekilde yüklendi"
                    ]);
                } else{
                    return response()->json([
                        'status' => "error",
                        'message' => "Bu Adisyonda Parapuan Tanımlaması Yaptınız Başka Parapuan Ekleyemezsiniz"
                    ]);
                }
            }

        }

        return response()->json([
            'status' => "error",
            'message' => "Bu Adisyonda Tahsil Edilmemiş ".$adission->remainingTotal()." TL Ödeme Bulunmaktadır. Ödemenin tamamını aldıktan sonra parapuan yüklemesi yapabilirsiniz."
        ]);

    }
    /**
     * Adisyon Tahsilatsız Kapat
     *
     * @param Appointment $adission
     * @return \Illuminate\Http\JsonResponse
     */
    public function closePayment(Appointment $adission)
    {
        if ($adission->remainingTotal() > 0){
            $adission->status = 6;
            $adission->save();

            $remainingPayment = new RemainingPayment();
            $remainingPayment->business_id = $adission->business_id;
            $remainingPayment->appointment_id = $adission->id;
            $remainingPayment->price = $adission->remainingTotal();
            if ($remainingPayment->save()){
                return back()->with('response',[
                    'status' => "success",
                    'message' => "Adisyon Başarılı Bir Şekilde Tahsilatsız Olarak Kapatıldı."
                ]);
            }
        }
        return back()->with('response',[
            'status' => "error",
            'message' => "Adisyon ücretinin tamamı ödendi. Tahsilatsız Olarak Kapatamazsınız"
        ]);

    }
    /**
     * Adisyon Tahsilat Silme
     *
     * @param AppointmentCollectionEntry $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Appointment $adission, AppointmentCollectionEntry $payment)
    {
        $adission->earned_point -= $this->calculateAppointmentEarnedPoint($payment, $adission);
        $adission->save();
        if($payment->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Tahsilat Başarılı Bir Şekilde Silindi"
            ]);
        }
    }

    /**
     * Adisyon Tahsilat Güncelle
     *
     * @param AppointmentCollectionEntry $payment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PaymentAddRequest $request,Appointment $adission, AppointmentCollectionEntry $payment)
    {
        if ($this->remainingTotal($adission) == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu Adisyonda tüm ücretler tahsil edildi. Başka Tahsilat Ekleyemezsiniz."
            ], 422);
        }
        if($request->price > $this->remainingTotal($adission)){
            return response()->json([
                'status' => "error",
                'message' => "Adisyonda tahsil edilecek tutar ". $this->remainingTotal($adission). " TL'dir. Bu ücretten daha yüksek bir ücret giremezsiniz",
                'price' => $this->remainingTotal($adission)
            ], 422);
        }


        $adissionEarnedPoint = $this->saveAppointmentEarnedPoint($request, $adission);
        if ($adissionEarnedPoint){
            $adission->earned_point -= $this->calculateAppointmentEarnedPoint($payment, $adission); //tahsilatta kazanılan puanı adisyondan düşür
            $adission->save();
            $payment->appointment_id = $adission->id;
            $payment->payment_type_id = $request->payment_type_id;
            $payment->price = $request->price;
            $payment->save();
            return response()->json([
                'status' => "success",
                'message' => "Tahsilat Başarılı Bir Şekilde Güncellendi"
            ]);
        }

        return response()->json([
            'status' => "error",
            'message' => "Hata! Ödeme Yöntemi Bulunamadı"
        ], 422);

    }
    public function saveAppointmentEarnedPoint($request, $adission)
    {
        $promossion = $this->business->promossions;

        switch ($request->paymentType){
            case 0:
                $discountRate = $promossion->cash;
                break;
            case 1:
                $discountRate = $promossion->credit_cart;
                break;
            case 2:
                $discountRate = $promossion->eft;
                break;
            default:
                $discountRate = 0;
        }
        //dd($discountRate);
        $discountTotal= ($request->price * $discountRate) / 100;
        $adission->earned_point += $discountTotal;
        $adission->save();
        return true;

    }
    public function calculateAppointmentEarnedPoint($request, $adission)
    {
        $promossion = $this->business->promossions;
        $discountRate = 0;

        switch ($request->paymentType){
            case 0:
                $discountRate = $promossion->cash;
                break;
            case 1:
                $discountRate = $promossion->credit_cart;
                break;
            case 2:
                $discountRate = $promossion->eft;
                break;
            default:
                $discountRate = 0;
        }
        //dd($discountRate);
        $discountTotal= ($request->price * $discountRate) / 100;
        return $discountTotal;

    }

}
