<?php

namespace App\Http\Controllers\Business\Official;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessOfficial\BusinessOfficialAddRequest;
use App\Http\Requests\BusinessOfficial\BusinessOfficialPasswordUpdateRequest;
use App\Http\Requests\BusinessOfficial\BusinessOfficialUpdateRequest;
use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

/**
 * @group BusinessOfficial
 *
 */
class BusinessOfficialController extends Controller
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

    /**
     * Yetkili Listesi
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $branches = Business::where("company_id", $this->business->company_id)->get();

        return view('business.official.index', compact('branches'));
    }

    /**
     * Yetkili Ekleme
     *
     * branch_id şube seçiniz alnından seçilen şubenin idsi olacak
     * @param BusinessOfficialAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BusinessOfficialAddRequest $request)
    {
        if ($this->existEmail($request->input('email'))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu e-posta adresi ile kayıtlı yetkili bulunmakta"
            ]);
        }
        if ($this->existPhone(clearPhone($request->input('phone')))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı yetkili bulunmakta"
            ]);
        }
        $official = new BusinessOfficial();
        $official->name = $request->input('name');
        $official->phone = clearPhone($request->input('phone'));
        $official->email = $request->input('email');
        $official->password = Hash::make($request->input('password'));
        $official->business_id = $request->input('branch_id');
        if ($official->save()) {
            $official->company_id = $official->business->company_id;
            $official->save();
            return response()->json([
                'status' => "success",
                'message' => "Yetkili " . $official->business->name . " İşletmenize Eklendi"
            ]);
        }
    }

    /**
     * Yetkili Düzenle
     *
     * @param BusinessOfficial $official
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessOfficial $businessOfficial)
    {
        $official = $businessOfficial;
        $branches = Business::where("company_id", $this->business->company_id)->get();
        return view('business.official.detail.show', compact('official', 'branches'));
    }

    /**
     * Yetkili Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param BusinessOfficial $official
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(BusinessOfficialUpdateRequest $request, BusinessOfficial $businessOfficial)
    {
        $official = $businessOfficial;
        if ($official->email != $request->input('email') && $this->existEmail($request->input('email'))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu e-posta adresi ile kayıtlı yetkili bulunmakta"
            ]);
        }

        if ($official->phone != clearPhone($request->input('phone')) && $this->existPhone(clearPhone($request->input('phone')))) {
            return response()->json([
                'status' => "error",
                'message' => "Bu telefon numarası ile kayıtlı yetkili bulunmakta"
            ]);
        }

        $official->name = $request->input('name');
        $official->phone = clearPhone($request->input('phone'));
        $official->email = $request->input('email');
        if ($request->hasFile('image')) {
            $response = UploadFile::uploadFile($request->file('image'));
            $official->image = $response["image"]["way"];
        }
        if ($request->filled('password')){
            $official->password = Hash::make($request->input('password'));
        }
        $official->business_id = $request->input('branch_id');
        if ($official->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Yetkili Güncellendi"
            ]);
        }
    }

    public function passwordUpdate(BusinessOfficialPasswordUpdateRequest $request)
    {
        $user = $this->user;
        $user->password = Hash::make($request->input('password'));
        if ($user->save()){
            return back()->with('response',[
                'status' => "success",
                'message' => "Şifreniz Güncellendi"
            ]);
        }
    }
    /**
     * Yetkili Silme
     *
     * @param BusinessOfficial $official
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessOfficial $official)
    {
        if ($official->is_admin == 1){
            return response()->json([
                'status' => "error",
                'message' => "Bu yetkili admin olduğu için hesabı silemezsiniz ancak bilgilerini güncelleyebilirsiniz."
            ]);
        }
        if ($official->delete()){
            return response()->json([
                'status' => "success",
                'message' => "Yetkili Silindi"
            ]);
        }
    }

    public function existPhone($phone)
    {
        $existPhone = BusinessOfficial::where('phone', clearPhone($phone))->exists();
        if ($existPhone) {
            return true;
        } else {
            return false;
        }
    }

    public function existEmail($email)
    {
        $existPhone = BusinessOfficial::where('email', $email)->exists();
        if ($existPhone) {
            return true;
        } else {
            return false;
        }
    }

    public function datatable()
    {
        $officials = $this->business->officials()->whereNot('id', $this->user->id)->get();
        return DataTables::of($officials)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessOfficial', 'Seçtiğiniz yetlili ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('business', function ($q) {
                return $q->business->branh_name ?? $q->business->name;
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessOfficial', 'status');
            })
            ->addColumn('phone', function ($q) {
                return createPhone('tel:'. formatPhone($q->phone), formatPhone($q->phone));
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.business-official.edit', $q->id));
                $html .= create_delete_button('BusinessOfficial', $q->id, 'Yetkili', 'Yekili Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }

}
