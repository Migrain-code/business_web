<?php

namespace App\Http\Controllers;

use App\Models\BusinessRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BusinessRoomController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        //$this->middleware(["permission:customRoom.view"]);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            $this->business = $this->user->business;
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('business.room.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $businessRoom = new BusinessRoom();
        $businessRoom->business_id = $this->business->id;
        $businessRoom->name = $request->input('name');
        $businessRoom->color = $request->input('color_code');
        $businessRoom->increase_type = $request->input('increase_type');
        $businessRoom->price = $request->input('price');
        if ($businessRoom->save()){
            return response()->json([
               'status' => "success",
               'message' => "Oda Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessRoom $room)
    {
        return view('business.room.detail.show', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BusinessRoom $room)
    {
        $room->business_id = $this->business->id;
        $room->name = $request->input('name');
        $room->color = $request->input('color_code');
        $room->increase_type = $request->input('increase_type');
        $room->price = $request->input('price');
        if ($room->save()){
            return response()->json([
                'status' => "success",
                'message' => "Oda Bilgileri Başarılı Şekilde Güncellendi"
            ]);
        }
    }

    public function datatable()
    {
        $rooms = $this->business->rooms;
        return DataTables::of($rooms)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessRoom', 'Seçtiğiniz yetlili ile ilgili tüm kayıtlar silinecektir. Bu işlem geri alınamayacaktır. Yetkilileri');
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessRoom', 'status');
            })
            ->editColumn('increase_type', function ($q) {
                return $q->increase_type == 0 ? "TL Fiyat Arttırma" : "Yüzdelik Fiyat Arttırma";
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.room.edit', $q->id));
                $html .= create_delete_button('BusinessRoom', $q->id, 'Oda', 'Oda Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir', 'false', '/isletme/ajax/delete/object', 'false');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name', 'color'])
            ->make(true);
    }

}
