<?php

namespace App\Http\Controllers\Personel\Adission;

use App\Http\Controllers\Controller;
use App\Http\Requests\Adission\CashPointUseRequest;
use App\Http\Resources\Customer\CashPointListResoruce;
use App\Http\Resources\Receivable\ReceivableListResource;
use App\Models\Appointment;
use App\Models\AppointmentReceivable;
use App\Models\CustomerCashPoint;
use Illuminate\Http\Request;

/**
 * @group Adisyonlar
 *
 */
class AdissionAddCashPointController extends Controller
{
    /**
     * Adisyon Parapuan Listesi
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function index(Appointment $adission)
    {
        $customer = $adission->customer;
        return response()->json($customer->cashPoints);
    }

    /**
     * Adisyon Parapuan Kullan
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(Appointment $adission, CashPointUseRequest $request)
    {
        $cashPoint = CustomerCashPoint::find($request->cashpoint_id);
        if ($adission->remainingTotal() == 0) {
            return back()->with('response',[
                'status' => "error",
                'message' => "Bu Adisyonda tüm ücretler tahsil edildi. Parapuan Kullanımı Yapılamaz."
            ]);
        }

        if ($cashPoint->price > $adission->remainingTotal()) { // parapuan tutarı kalan tutardan fazlaysa
            $collectionTotal = $cashPoint->price - $adission->remainingTotal(); // "parapuandan kalan" price = 25  - kalan ödeme = 15 parapuandan kalan = 10
            $adission->point = $adission->remainingTotal();
            $adission->save();

            $cashPoint->price = $collectionTotal; // kalan tutarı parapuana yazdır
            $cashPoint->save();
            return back()->with('response',[
                'status' => "warning",
                'message' => "Parapuan Ödemeye Uygulandı. Parapuan tutarı ödeme tutarından fazla oluduğu için parapuandan " . $adission->point . " TL tahsil edildi."
            ]);
        } else{
            $adission->point = $cashPoint->price;
            $adission->save();
            $cashPoint->price = 0;
            $cashPoint->save();
        }


        return back()->with('response',[
            'status' => "success",
            'message' => "Parapuan Başarılı Bir Şekilde Kullanıldı"
        ]);
    }
    /**
     * Adisyon Alacak Listesi
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableList(Appointment $adission)
    {
        return response()->json(ReceivableListResource::collection($adission->receivables
            //->whereStatus(0)->get()
        ));
    }
    /**
     * Adisyon Alacak Oluştur
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableAdd(Request $request,Appointment $adission)
    {
        if ($adission->remainingTotal() == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu adisyonun tüm ücreti tahsil edildi.Yeni Alacak ekleyemezsiniz."
            ]);
        }
        $totalReceivable = $adission->receivables()->whereStatus(0)->sum('price');
        if ($request->price > $adission->remainingTotal() - $totalReceivable){

            $sum = $adission->remainingTotal() - $totalReceivable;

            if ($sum == 0){
                return response()->json([
                    'status' => "success",
                    'message' => "Eklediğiniz alacak ile birlikte bu adisyonun tüm tutarı alınmış oldu. Bu adisyon için daha fazla alacak ekleme yapamazsınız"
                ]);
            }

            return response()->json([
                'status' => "error",
                'message' => "Adisyona Eklediğiniz Alacakların Toplamı ve Gönderdiğini Tutar Adisyonun Kalan Ücretini Geçemez. ". $sum . " TL'den fazla fiyat giremezsiniz."
            ]);
        }
        if ($request->price  > $adission->remainingTotal()){
            return response()->json([
                'status' => "error",
                'message' => "Gönderdiğiniz Tutar. Adisyonun Kalan Ücretini Geçemez. ". $adission->remainingTotal(). " TL'den fazla fiyat giremezsiniz."
            ]);
        }
        $receivable = new AppointmentReceivable();
        $receivable->appointment_id = $adission->id;
        $receivable->business_id = $adission->business_id;
        $receivable->customer_id = $adission->customer_id;
        $receivable->payment_date = $request->paymentDate;
        $receivable->price = $request->price;
        $receivable->note = $request->note;
        if ($receivable->save()){
            return response()->json([
                'status' => "success",
                'message' => "Alacak Başarılı Bir Şekilde Oluşturuldu"
            ]);
        }
    }
    /**
     * Adisyon Alacak Sil
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableDelete(Appointment $adission, AppointmentReceivable $receivable)
    {
        if ($receivable->status == 1){
            return response()->json([
                'status' => "success",
                'message' => "Ödemesi Onaylanmış Bir Alacağı Silemezsiniz"
            ], 422);
        }
        if ($receivable->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Alacak Başarılı Bir Şekilde Silindi"
            ]);
        }
    }

    /**
     * Adisyon Alacak Ödendi Güncelle
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function receivableUpdate(Appointment $adission, AppointmentReceivable $receivable)
    {
        if ($receivable->status == 1){
            return response()->json([
                'status' => "error",
                'message' => "Ödemeyi Daha Önce Onayladınız"
            ], 422);
        }
        $receivable->status = 1;
        if ($receivable->save()){

            return response()->json([
                'status' => "success",
                'message' => "Alacak Ödemesi Başarılı Bir Şekilde Onaylandı"
            ]);
        }
    }

}
