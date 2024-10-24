<?php

namespace App\Http\Controllers\Business\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerAddRequest;
use App\Models\BusinessCustomer;
use App\Models\Customer;
use App\Models\CustomerNotificationPermission;
use App\Models\NotificationIcon;
use App\Services\Sms;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    private $business;
    private $user;

    public function __construct()
    {
        $this->middleware(['permission:customer.list'])->only('index');
        $this->middleware(['permission:customer.show'])->only('edit');
        $this->middleware(['permission:customer.info.update'])->only('update');
        $this->middleware(function ($request, $next) {
            $this->user = auth('official')->user();
            $this->business = $this->user->business;
            return $next($request);
        });

    }
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
        if (strlen(clearPhone($request->input('phone'))) != 11){
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Telefon Numarasını 11 Haneli olarak giriş yapın"
            ]);
        }
        $generatePassword = rand(100000, 999999);
        $customer = new Customer();
        $customer->name = $request->input('name');
        $customer->email = $request->input('email');
        $customer->phone = clearPhone($request->input('phone'));
        $customer->city_id = $request->input('city_id');
        $customer->district_id = $request->input('district_id');
        $customer->password = Hash::make($generatePassword);
        $customer->gender = $request->input('gender');
        $customer->status = 1;
        $customer->verify_phone = 1;
        if ($request->hasFile('image')) {
            $response = UploadFile::uploadFile($request->file('image'));
            $customer->image = $response["image"]["way"];
        }
        if ($customer->save()) {
            $message = "Merhaba ".$customer->name.", Hızlı Randevu'ya Hoşgeldiniz.
                        Giriş Bilgileriniz: Tel: ".$customer->phone." Şifre: ".$generatePassword."
                        İyi günler dileriz
                        ".$this->business->name."
                        (Hızlı Randevu)";
            //Sms::send($customer->phone, $message);
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
    public function edit(Customer $customer)
    {
        $existCustomer = $this->business->customers()->where('customer_id', $customer->id)->exists();
        if (!$existCustomer){
            return to_route('business.customer.index')->with('response',[
                'status' => "error",
                'message' => "Bu müşteri sizin listenize kayıtlı olmadığı için görüntüleyemezsiniz"
            ]);
        }
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
        if (strlen(clearPhone($request->input('app_phone'))) != 11){
            return response()->json([
                'status' => "error",
                'message' => "Lütfen Telefon Numarasını 11 Haneli olarak giriş yapın"
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
                'message' => "Müşteri Bilgileri Başarılı Bir Şekilde Güncellendi"
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
        $business = $this->business;
        $customers = $business->customers()->has('customer')->with('customer')->select('id', 'customer_id', 'status', 'created_at')
            ->when($request->filled('name'), function ($q) use ($request) {
                $name = strtolower($request->input('name'));
                $q->whereHas('customer', function ($q) use ($name) {
                    $q->whereRaw('LOWER(name) like ?', ['%' . $name . '%']);
                });
            })
            ->latest()
            ->take(50)->get();

        return DataTables::of($customers)
            ->editColumn('id', function ($q) {
                return createCheckbox($q->id, 'BusinessCustomer', 'Müşterileri');
            })
            ->editColumn('name', function ($q) {
                return createName(route('business.customer.edit', $q->customer->id), $q->customer->name);
            })
            ->editColumn('phone', function ($q) {
                if (authUser()->hasPermissionTo('customer.phone.show')){
                    return createPhone($q->customer->phone, formatPhone($q->customer->phone));
                } else{
                    return maskPhone($q->customer->phone);
                }
            })
            ->editColumn('status', function ($q) {
                if (authUser()->hasPermissionTo('customer.banned')){
                    return create_switch($q->id, $q->status == 1 ? true : false, 'BusinessCustomer', 'status');
                } else{
                    return $q->status == 1 ? "Randevu Alabilir" : "Randevu Alamaz";
                }
            })
            ->addColumn('appointmentCount', function ($q) use ($business) {
                return $q->customer->appointments()->where('business_id', $business->id)->count();
            })
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d.m.Y H:i');
            })
            ->addColumn('action', function ($q) {
                $html = "";
                $html .= create_edit_button(route('business.customer.edit', $q->customer->id));
                if (authUser()->hasPermissionTo('customer.delete')){
                    $html .= create_delete_button('BusinessCustomer', $q->id, 'Müşteri', 'Müşteri Kaydını Silmek İstediğinize Eminmisiniz? Kayıt Sadece İşletmenizden Silinecektir');
                }
                return $html;
            })
            ->rawColumns(['id', 'action', 'name'])
            ->make(true);
    }
}
