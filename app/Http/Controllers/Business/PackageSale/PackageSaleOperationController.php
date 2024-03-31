<?php

namespace App\Http\Controllers\Business\PackageSale;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageSale\PackageSaleAddPaymentRequest;
use App\Http\Requests\PackageSale\PackageSaleAddUsageRequest;
use App\Http\Resources\PackageSale\PackageSalePaymentsListResource;
use App\Http\Resources\PackageSale\PackageSaleUsagesListResource;
use App\Models\PackagePayment;
use App\Models\PackageSale;
use App\Models\PackageSalePolicy;
use App\Models\PackageUsage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group PackageSale
 *
 */
class PackageSaleOperationController extends Controller
{
    private $business;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth('official')->user()->business;
            return $next($request);
        });
    }
    /**
     * Paket Satışı Ödemeler
     *
     * @param PackageSale $packageSale
     * @return Response
     */
    public function payments(PackageSale $packageSale)
    {
        return response()->json(PackageSalePaymentsListResource::collection($packageSale->payeds()->latest()->get()));
    }

    /**
     * Paket Satışı Kullanımlar
     *
     * @param PackageSale $packageSale
     * @return Response
     */
    public function usages(PackageSale $packageSale)
    {
        return response()->json(PackageSaleUsagesListResource::collection($packageSale->usages));
    }

    /**
     * Paket Satışı Kullanım Ekle
     *
     * Personel listesine istek atılarak personel listesini alabilirsiniz
     * @param PackageSale $packageSale
     * @return Response
     */
    public function usagesAdd(PackageSaleAddUsageRequest $request, PackageSale $packageSale)
    {
        $remainingUsage = $packageSale->amount - $packageSale->usages->sum('amount');

        if ($remainingUsage >= $request->amount) {
            $usage = new PackageUsage();
            $usage->package_id = $packageSale->id;
            $usage->personel_id = $request->personel_id;
            $usage->amount = $request->amount;
            $usage->created_at = $request->operation_date;
            if ($usage->save()) {
                return response()->json([
                    'status' => "success",
                    'message' => "Kullanım Eklendi"
                ]);
            }
        } else {
            $message = "Paketin Maximum Kullanım Miktarı : " . $packageSale->amount. " Ekleyebileceğiniz kullanım miktarı: ". $remainingUsage;
            return response()->json([
                'status' => "error",
                'message' => $message
            ]);
        }

    }

    /**
     * Paket Satışı Ödeme Ekle
     *
     * @param PackageSale $packageSale
     * @return JsonResponse
     */
    public function paymentsAdd(PackageSaleAddPaymentRequest $request, PackageSale $packageSale)
    {
        $remainingPrice = $packageSale->total - $packageSale->payeds->sum('price');
        $remainingAmount = $packageSale->amount - $packageSale->payeds->sum('amount');
        if ($request->price > $remainingPrice) {
            return response()->json([
                'status' => "error",
                'message' => "Bu paketin " . $remainingPrice . " ödemesi kaldı. Paketin Kalan ödemesinden büyük fiyat bilgisi giremezsiniz"
            ]);
        }
        if ($request->amount > $remainingAmount) {
            return response()->json([
                'status' => "error",
                'message' => "Bu paketin " . $remainingAmount . " " . $packageSale->packageType('name') . " ödemesi kaldı. Bu değerden büyük bir değer giremezsiniz"
            ]);
        }
        $payment = new PackagePayment();
        $payment->package_id = $packageSale->id;
        $payment->price = $request->price;
        $payment->amount = $request->amount;
        if ($payment->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Ödeme Eklendi"
            ]);
        }
    }

    /**
     * Paket Satışı Ödeme Silme
     *
     * Urlde gönderilecek olan id payment id olacak
     * @param PackageSale $packageSale
     * @return Response
     */
    public function deletePayment(PackagePayment $packagePayment)
    {
        if ($packagePayment->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Ödeme Silindi"
            ]);
        }
    }

    /**
     * Paket Satışı Kullanım Silme
     *
     * Urlde gönderilecek olan id, usage id olacak
     * @param PackageSale $packageSale
     * @return Response
     */
    public function deleteUsage(PackageUsage $packageUsage)
    {
        if ($packageUsage->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Kullanım Silindi"
            ]);
        }
    }

    public function addPolicy(Request $request, PackageSale $packageSale)
    {
        //$request->dd();
        $packagesalePolicy = new PackageSalePolicy();
        $packagesalePolicy->business_id = $this->business->id;
        $packagesalePolicy->package_sale_id = $packageSale->id;
        $packagesalePolicy->file_name = $request->file_number;

        if ($request->hasFile('policy_file')) {
            //$response = UploadFile::uploadFile($request->file('profilePhoto'));
            //$packagesalePolicy->policy_file  = $response["image"]["way"];
        }
        if ($packagesalePolicy->save()){
            return back()->with('response', [
               'status' => "success",
               'message' => "Dosya Yüklendi"
            ]);
        }
    }
}
