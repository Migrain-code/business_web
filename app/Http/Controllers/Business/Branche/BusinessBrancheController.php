<?php

namespace App\Http\Controllers\Business\Branche;

use App\Http\Controllers\Controller;
use App\Http\Requests\Branches\BranchAddRequest;
use App\Http\Resources\Branches\BusinessBrancesResource;
use App\Http\Resources\BusinessOfficial\BusinessOfficialListResource;
use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Models\BusinessPromossion;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

/**
 * @group Şubeler
 *
 */
class BusinessBrancheController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->business = auth()->user()->business;
            $this->user = auth()->user();
            return $next($request);
        });
    }
    /**
     * Şube Listesi
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $officials = BusinessOfficial::where("company_id", $this->business->company_id)->get();

        return view('business.branche.index', compact('officials'));
    }
    /**
     * Şube Düzenle
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Business $branche)
    {
        $officials = BusinessOfficial::where("company_id", $this->business->company_id)->get();
        return view('business.branche.detail.show', compact('branche', 'officials'));
    }
    /**
     * Şube Ekle
     *
     * @param  BranchAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BranchAddRequest $request)
    {
        if ($this->existBusiness(Str::slug($request->input('business_name')))){
            return response()->json([
                'status' => "error",
                'message' => "Bu İşletme Adı Daha Önce Kayıt Edilmiş. Lütfen Başka işletme adı ile giriş yapınız"
            ]);
        }
        $business = new Business();
        $business->name = $request->input('business_name');
        $business->slug = Str::slug($request->input('business_name'));
        $business->branch_name = $request->input('name');
        $business->company_id = $this->business->company_id;
        $business->package_id = 1;
        if ($business->save()){
            return response()->json([
               'status' => "success",
               'message' => "Şube Eklendi"
            ]);
        }
    }

    /**
     * Şube Değiştir
     *
     * Burada giriş yapan kullanıcının default şube bilgisi değişecek
     * @param   Business $branche
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Business $branche)
    {
        if ($branche->id == $this->business->id){
            return response()->json([
                'status' => "error",
                'message' => "Aynı işletmedesiniz"
            ]);
        }
        else{
            $findOfficial = BusinessOfficial::where('business_id', $this->business->id)->first();
            $findOfficial->business_id = $this->user->business_id;

            if ($findOfficial->save()){
                $user = $this->user;
                $user->business_id = $branche->id;
                $user->save();
                return back()->with('response',[
                    'status' => "success",
                    'message' => "Şube Değiştirme İşlemi Başarılı",
                ]);
            }
        }
    }

    public function update(BranchAddRequest $request, Business $branche)
    {
        $slugedName = Str::slug($request->input('business_name'));
        if ($slugedName != $branche->slug && $this->existBusiness($slugedName)){
            return response()->json([
                'status' => "error",
                'message' => "Bu İşletme Adı Daha Önce Kayıt Edilmiş. Lütfen Başka işletme adı ile giriş yapınız"
            ]);
        }

        $branche->name = $request->input('business_name');
        $branche->slug = $slugedName;
        $branche->branch_name = $request->input('name');
        $branche->company_id = $this->business->company_id;
        $branche->package_id = 1;
        if ($branche->save()){

            $this->addPromotion($branche->id);
            return response()->json([
                'status' => "success",
                'message' => "Şube Bilgileri Güncellendi"
            ]);
        }
    }
    /**
     * Şube Sil
     *
     * @param  Business $branche
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $branche)
    {
        if ($branche->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Şube Silindi",
            ]);
        }
    }

    public function addPromotion($businessId)
    {
        $promossions = new BusinessPromossion();
        $promossions->business_id = $businessId;
        $promossions->save();

        return $promossions;
    }
    public function existBusiness($businessName)
    {
        return Business::where('slug', $businessName)->exists();
    }

    public function datatable()
    {
        $branches = Business::where('id','<>', $this->business->id)->where("company_id", $this->business->company_id)->get();
        return DataTables::of($branches)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'Business', 'Seçtiğiniz şube ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Şubeleri');
            })
            ->editColumn('official', function ($q) {
                if (isset($q->official)){
                    return createName('', $q->official->name);
                }
                return "Yetkili Bulunamadı";
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'Business', 'status');
            })
            ->addColumn('appointmentCount', function ($q) {
                return $q->appointments()->count();
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_swap_button(route('business.branche.edit', $q->id));
                $html .= create_edit_button(route('business.branche.show', $q->id));
                //$html .= create_delete_button('Business', $q->id, 'Şube', 'Şube Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
