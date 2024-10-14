<?php

namespace App\Http\Controllers;

use App\Http\Requests\BusinessOfficial\BusinessOfficialUpdateRequest;
use App\Models\Business;
use App\Models\BusinessOfficial;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class OfficialSettingController extends Controller
{
    public function index()
    {
        $official = authUser();
        $branches = Business::where("company_id", $official->business->company_id)->get();
        return view('business.official.setting.show', compact('official', 'branches'));
    }

    public function update(BusinessOfficialUpdateRequest $request, BusinessOfficial $businessOfficial)
    {
        $official = authUser();
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
                'message' => "Bilgileriniz Güncellendi"
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
}
