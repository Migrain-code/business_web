<?php

namespace App\Http\Controllers\Business\Gallery;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\GalleryAddRequest;
use App\Http\Resources\Gallery\GalleryListResource;
use App\Models\BusinessGallery;
use App\Models\CustomerGallery;
use App\Services\UploadFile;

/**
 * @group CustomerGallery
 *
 */
class CustomerGalleryController extends Controller
{
    private $business;
    public function __construct()
    {
        $this->middleware('permission:business.customerGallery.list');
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
        $galleries = $this->business->customerGallery;

        return view('business.customer-gallery.index', compact('galleries'));
    }

    /**
     * Görsel Silme
     *
     * @param BusinessGallery $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CustomerGallery $customerGallery)
    {
        if ($customerGallery->delete()) {
            return response()->json([
                'status' => "success",
                'message' => "Görsel Silindi"
            ]);
        }
    }

}
