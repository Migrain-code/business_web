<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\District;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function updateFeatured(Request $request)
    {
        $query = $request->model::find($request->id);
        $query->{$request->column} = $request->value;
        $message = $request->value == 0 ? "Engellendi" : "Aktif";
        if ($query->save()) {
            return [
                'status' => 'success',
                'message' => 'Durum '. $message .' olarak güncellendi',
            ];
        }

        return [
            'status' => 'error',
            'message' => 'Sistemde oluşan bir hata nedeniyle işleminiz yapılamadı !'
        ];
    }

    public function deleteFeatured(Request $request)
    {
        $query = $request->model::find($request->id);

        if ($query){
            if ($request->delete_type == 1){
                $query->delete();
            } else{
                $query->is_delete = 1;
                $query->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => $request->input('title'). " Kaydı Silindi"
            ]);
        }
        else{
            return response()->json([
                'status' => 'warning',
                'message' => 'Bir Hata Sebebiyle '. $request->input('title'). "Silinemedi"
            ]);
        }
    }

    public function deleteAllFeatured(Request $request)
    {
        foreach ($request->ids as $id){
            $query = $request->model::find($id);
            if ($request->is_delete == 1){
                if ($query){
                    $query->delete();
                }
            }
            else{
                $query->is_delete = 1;
                $query->save();
            }

        }

        return response()->json([
            'status' => 'success',
            'message' => $request->input('title'). " Kaydı Silindi"
        ]);

    }

    public function getDistrict(Request $request)
    {
        $districts = District::where('city_id', $request->id)->get();

        return $districts;
    }
}
