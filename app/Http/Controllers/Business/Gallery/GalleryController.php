<?php

namespace App\Http\Controllers\Business\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\GalleryAddRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\BusinessGallery;
use App\Services\UploadFile;
use Intervention\Image\Laravel\Facades\Image;


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
                $businessGallery = new BusinessGallery();
                $businessGallery->business_id = $this->business->id;
                $businessGallery->way = $this->insertFiligran($file);
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

    public function insertFiligran($file)
    {
        $fileName = $file->getClientOriginalName();
        $img = Image::read($file);

        $img->place(
            public_path('/business/assets/media/logos/filigran_logo.png'),
            'center',
            10,
            10,
            30
        );
        $tempPath = 'temp/' . uniqid().".webp";

        $img->save(storage_path('app/' . $tempPath));
        $tempFile = new \Illuminate\Http\File(storage_path('app/' . $tempPath));

        // Geçici dosyayı yükleme sınıfına gönder
        $response = UploadFile::uploadFile($tempFile, 'business_galleries', $fileName);
        // Geçici dosyayı sil
        Storage::delete($tempPath);
        return $response["image"]["way"];
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
