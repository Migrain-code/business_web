<?php

namespace App\Http\Controllers\Business\Service;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\ServiceAddRequest;
use App\Http\Resources\Business\BusinessServiceResource;
use App\Http\Resources\Service\PersonelListResource;
use App\Http\Resources\Service\ServiceCategoryResource;
use App\Http\Resources\Service\ServiceSubCategoryResource;
use App\Models\BusinessService;
use App\Models\BusinnessType;
use App\Models\Personel;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

/**
 * @group Services
 *
 */
class ServiceController extends Controller
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
     * Hizmet Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $serviceCategories = ServiceCategory::all();
        $business = $this->business;
        if ($business->type_id == 3){
            $typeList = BusinnessType::all();
        } else{
            $typeList = BusinnessType::whereId($business->type_id)->get();
        }

        return view('business.service.index', compact('serviceCategories', 'typeList', 'business'));
    }

    /**
     * Hizmet Oluştur
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $serviceCategory = ServiceCategory::find($request->category_id);

        return response()->json(ServiceSubCategoryResource::collection($serviceCategory->subCategories));
    }

    /**
     * Hizmet Ekle
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ServiceAddRequest $request)
    {
        $findService = $this->business->allServices()
            ->where('sub_category', $request->input('subCategoryId'))
            ->where('category', $request->input('categoryId'))
            ->where('type', $request->input('typeId'))->first();
        if ($findService){
            if ($findService->is_delete == 1){
                $findService->status = 0;
                $findService->save();
                return response()->json([
                    'status' => "success",
                    'message' => "Yeni Hizmet Eklendi",
                ]);
            } else{
                return response()->json([
                   'status' => "error",
                   'message' => "Bu hizmeti daha önce ekledini başka ekleyemezsiniz"
                ]);
            }

        }
        $newBusinessService = new BusinessService();
        $newBusinessService->business_id = $this->business->id;
        $newBusinessService->type = $request->typeId;
        $newBusinessService->category = $request->input('categoryId');
        $newBusinessService->sub_category = $request->input('subCategoryId');
        $newBusinessService->time = $request->input('time');
        $newBusinessService->price = $request->input('price');
        $newBusinessService->save();

        return response()->json([
            'status' => "success",
            'message' => "Yeni Hizmet Eklendi",
        ]);
    }

    /**
     * Hizmet Detayı
     *
     *  Bu apide ilgili hizmeti hangi personeller veriyor bunun listesi görüntülenecek
     * @param BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(BusinessService $service)
    {
        /*$personlIds = $service->personels()->pluck('personel_id')->toArray();
        $personels = Personel::whereIn('id', $personlIds)->get();
        return response()->json(PersonelListResource::collection($personels));*/
    }

    /**
     * Hizmet Düzenle
     *
     * @param BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(BusinessService $service)
    {
        $business = $this->business;
        $appointmentCount = $this->business->appointments()
            ->whereHas('services', function ($q) use ($service){
                $q->where('service_id', $service->id);
            })
            ->count();

        $personelCount = $this->business->personels()
            ->whereHas('services', function ($q) use ($service){
                $q->where('service_id', $service->id);
            })
            ->count();
        $packageCount = $this->business->packages()
            ->where('service_id', $service->id)
            ->sum('total');
        $serviceCategories = ServiceCategory::all();
        if ($business->type_id == 3){
            $typeList = BusinnessType::all();
        } else{
            $typeList = BusinnessType::whereId($business->type_id)->get();
        }
        return view('business.service.edit.index', compact('serviceCategories', 'typeList', 'service', 'appointmentCount', 'personelCount', 'packageCount'));
    }

    /**
     * Hizmet Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, BusinessService $service)
    {
        $findService = $this->business->allServices()
            ->where('sub_category', $request->input('subCategoryId'))
            ->where('category', $request->input('categoryId'))
            ->where('type', $request->input('typeId'))->first();
        if ($findService->id != $service->id){ // bulunan hizmet geçerli hizmet ile aynı değilse
            if ($findService->is_delete == 1){//hizmet silinmiş mi kontrol et 1 silinmiş
                $findService->is_delete = 0;
                $findService->save();
                return response()->json([
                    'status' => "info",
                    'message' => "Güncellemek istediğiniz hizmet daha önce
                    sildiğiniz bir hizmet ile eşleştiği için bu hizmeti sabit bırakıp.
                    Sildiğiniz hizmeti sizin için 'hizmet listenize geri ekledik'",
                ]);
            } else{
                return response()->json([
                    'status' => "error",
                    'message' => "Bu hizmet, hizmet listenizde bulunmaktadır. Lütfen başka bir seçim yapınız veya işlemi iptal ediniz."
                ]);
            }

        } else{
            if ($service) {
                $service->type = $request->typeId;
                $service->category = $request->input('categoryId');
                $service->sub_category = $request->input('subCategoryId');
                $service->time = $request->input('time');
                $service->price = $request->input('price');
                $service->save();

                return response()->json([
                    'status' => "success",
                    'message' => "Hizmet Bilgisi Güncellendi",
                ]);
            } else {
                return response()->json([
                    'status' => "error",
                    'message' => "Hizmet Bulunamadı",
                ]);
            }
        }

    }

    /**
     * Hizmet Sil
     *
     * @param BusinessService $service
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(BusinessService $service)
    {
        $service->is_delete = 1;
        if ($service->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Silindi",
            ]);
        }
    }

    function transformServices($womanServiceCategories)
    {
        $transformedDataWoman = [];
        foreach ($womanServiceCategories as $category => $services) {

            $transformedServices = [];
            foreach ($services as $service) {
                if ($service->personels->count() > 0) {
                    $transformedServices[] = [
                        'id' => $service->id,
                        'name' => $service->subCategory->getName(),
                        'price' => $service->price,
                    ];
                }
            }
            $transformedDataWoman[] = [
                'id' => $services->first()->category,
                'name' => $category,
                'services' => $transformedServices,
            ];
        }
        return $transformedDataWoman;
    }

    public function datatable(Request $request)
    {
        $business = $this->business;
        $services = $business->services;

        return DataTables::of($services)
            ->editColumn('category', function ($q) {
                return $q->categorys->name;
            })
            ->editColumn('sub_category', function ($q) {
                return $q->subCategory->name;
            })
            ->editColumn('type', function ($q) {
                return $q->gender->name;
            })
            ->editColumn('is_featured', function ($q) {
                return create_switch($q->id, $q->is_featured == 1 ? true : false, 'BusinessService', 'is_featured');
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->editColumn('price', function ($q) {
                return formatPrice($q->price);
            })
            ->addColumn('action', function ($q) use ($request){
                $html = '';

                $html .= create_edit_button(route('business.service.edit', $q->id), 'text-white');
                $html .= create_delete_button('BusinessService', $q->id, 'Hizmeti', 'Hizmeti Silmek istediğinize eminmisiniz?', 'false', '/isletme/service/' . $q->id, 'false');
                return $html;
            })
            ->rawColumns(['id', 'action'])
            ->make(true);
    }

}
