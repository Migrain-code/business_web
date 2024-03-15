<?php

namespace App\Http\Controllers\Business\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerAddRequest;
use App\Models\BusinessCustomer;
use App\Models\Customer;
use App\Models\CustomerNotificationPermission;
use App\Models\NotificationIcon;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('business.customer.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerAddRequest $request)
    {
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = clearPhone($request->input('phone'));
        $customer->city_id = $request->input('city_id');
        $customer->district_id = $request->input('district_id');
        $customer->password = Hash::make($request->input('password'));
        $customer->gender = $request->input('gender');
        $customer->status = 0;
        if ($request->hasFile('image')) {
            //$response = UploadFile::uploadFile($request->file('profilePhoto'));
            //$customer->image = $response["image"]["way"];
        }
        if ($customer->save()) {
            $this->addPermission($customer->id);
            $this->addBusinessCustomerList($customer->id);
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Başarılı Bir Şekilde Eklendi"
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessCustomer $customer)
    {
        $customer = $customer->customer;
        $noticifationIcons = NotificationIcon::all();
        return view('business.customer.detail.show', compact('customer', 'noticifationIcons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        if ($customer->business()->where('business_id', authUser()->business->id)->first()->type == 0){
            return response()->json([
                'status' => "error",
                'message' => "Bu Müşteri Randevu Alarak Gelmiş olan bir müşteri olduğu için bilgilerini düzenleyemezsiniz"
            ]);
        }
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = clearPhone($request->input('app_phone'));
        $customer->gender = $request->input('gender');
        $customer->birthday = $request->input('birthday');
        $customer->city_id = $request->input('city_id');
        $customer->district_id = $request->input('district_id');
        if ($request->hasFile('profilePhoto')) {
            $response = UploadFile::uploadFile($request->file('profilePhoto'));
            $customer->image = $response["image"]["way"];
        }
        if ($customer->save()) {
            return response()->json([
                'status' => "success",
                'message' => "Müşteri Başarılı Bir Şekilde Güncellendi"
            ]);
        }
    }

    public function existPhone($phone)
    {
        $existPhone = Customer::where('phone', $phone)->first();
        if ($existPhone != null) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
    public function addPermission($id)
    {
        $permission = new CustomerNotificationPermission();
        $permission->customer_id = $id;
        $permission->save();

        return $permission;
    }

    public function addBusinessCustomerList($id)
    {
        $businessCustomer = new BusinessCustomer();
        $businessCustomer->business_id = authUser()->business->id;
        $businessCustomer->customer_id = $id;
        $businessCustomer->type = 1;
        $businessCustomer->status = 1;
        $businessCustomer->save();
        return $businessCustomer;
    }

    public function datatable(Request $request)
    {
        $business = authUser()->business;
        $customers = $business->customers;

        return DataTables::of($customers)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessCustomer', 'Müşterileri');
            })
            ->editColumn('name', function ($q) {
                return createName(route('business.customer.edit', $q->id), $q->customer->name);
            })
            ->editColumn('phone', function ($q) {
                return createPhone($q->customer->phone, formatPhone($q->customer->phone));
            })
            ->editColumn('status', function ($q) {
                return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessCustomer', 'status');
            })
            ->addColumn('appointmentCount', function ($q) use ($business) {
                return $q->customer->appointments()->where('business_id', $business->id)->count();
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.customer.edit', $q->id));
                $html .= create_delete_button('BusinessCustomer', $q->id, 'Müşteri', 'Müşteri Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir');

                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }
}
