<?php

namespace App\Http\Controllers\Business\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\GalleryAddRequest;
use App\Http\Resources\Gallery\GalleryListResource;
use App\Models\BusinessGallery;
use App\Services\UploadFile;

/**
 * @group BusinessGallery
 *
 */
class GalleryController extends Controller
{
    private $business;
    private $totalQuota = 50;//50 mb kota
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            return $next($request);
        });
    }

    /**
     * İşletme Galerisi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $galleries = $this->business->gallery;
        $percentageUsed = $this->calculateQuota($galleries)["percentageUsed"];
        $usedMegabytes = $this->calculateQuota($galleries)["usedMegabytes"];
        return view('business.gallery.index', compact('galleries', 'percentageUsed', 'usedMegabytes'));
    }

    /**
     * Görsel Ekle
     *
     * @param GalleryAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(GalleryAddRequest $request)
    {
        $percentageUsed = $this->calculateQuota($this->business->gallery)["percentageUsed"];
        if ($percentageUsed != 100){
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                //$response = UploadFile::uploadFile($request->file('image'), 'business_galleries');
                $businessGallery = new BusinessGallery();
                $businessGallery->business_id = $this->business->id;
                $businessGallery->way = "asdsad"; //$response["image"]["way"];
                $businessGallery->byte = $file->getSize();
                $businessGallery->name = $this->business->name . "_" . $this->business->gallery->count();
                $businessGallery->save();
                return response()->json([
                    'status' => "success",
                    'message' => "Görsel Yüklendi"
                ]);
            } else {
                return response()->json([
                    'status' => "error",
                    'message' => "Lütfen Bir Dosya Seçiniz",
                ]);
            }
        } else{
            return response()->json([
                'status' => "error",
                'message' => "Kotayı tamamen doldurdunuz. Birkaç görsel silip tekrar yükleme yapabilirsiniz",
            ]);
        }

    }

    /**
     * Görsel Silme
     *
     * @param BusinessGallery $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessGallery $gallery)
    {
        if ($gallery->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Görsel Silindi"
            ]);
        }
    }

    public function calculateQuota($galleries)
    {
        $totalByte = $galleries->sum('byte');
        $kilobyte = $totalByte / 1024;
        $usedMegabytes = $kilobyte / 1024;
        $percentageUsed = ceil(($usedMegabytes / $this->totalQuota) * 100);

        return [
            'percentageUsed' => $percentageUsed,
            'usedMegabytes' => $usedMegabytes
        ];
    }
}
