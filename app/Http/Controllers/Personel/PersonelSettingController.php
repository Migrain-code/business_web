<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusinessOfficial\BusinessOfficialPasswordUpdateRequest;
use App\Http\Requests\PersonelAccount\PersonalUpdateRequest;
use App\Models\AppointmentRange;
use App\Models\BusinnessType;
use App\Models\DayList;
use App\Models\Personel;
use App\Models\PersonelRestDay;
use App\Models\PersonelService;
use App\Services\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PersonelSettingController extends Controller
{
    public function notifications()
    {
        $personel = authUser();
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        $startOfYear = now()->startOfYear();
        $endOfYear = now()->endOfYear();

        $monthNotifications = $personel->notifications()->whereBetween('created_at', [$startOfMonth, $endOfMonth])->get();
        $yearNotifications = $personel->notifications()->whereBetween('created_at', [$startOfYear, $endOfYear])->get();
        $weekNotifications = $personel->notifications()->whereBetween('created_at', [$startOfWeek, $endOfWeek])->get();
        $dayNotifications = $personel->notifications()->whereDate('created_at', now()->toDateString())->get();

        return view('personel.notification.index', compact('personel', 'dayNotifications', 'weekNotifications', 'monthNotifications', 'yearNotifications'));

    }

    public function settings()
    {
        $personel = authUser();

        $dayList = DayList::all();
        $services = $personel->business->services;
        $ranges = AppointmentRange::all();
        $types = BusinnessType::all();
        return view('personel.setting.index', compact('personel', 'dayList', 'services', 'ranges', 'types'));
    }

    /**
     * Personel Güncelle
     *
     * @param \Illuminate\Http\Request $request
     * @param Personel $personel
     * @return \Illuminate\Http\Response
     */
    public function update(PersonalUpdateRequest $request)
    {
        $personel = authUser();
        $personel->name = $request->input('name');
        $personel->email = $request->email;
        if ($request->filled('password')){
            $personel->password = Hash::make($request->password);
        }
        $personel->phone = $request->phone;
        $personel->accepted_type = $request->approve_type;
        $personel->start_time = $request->start_time;
        $personel->end_time = $request->end_time;
        $personel->food_start = $request->food_start_time;
        $personel->food_end = $request->food_end_time;
        $personel->gender = $request->gender_type;
        $personel->range = $request->range;
        $personel->description = $request->description;
        $personel->rest_day = $request->restDay[0];

        if ($request->hasFile('avatar')) {
            $response = UploadFile::uploadFile($request->file('avatar'), 'personel_images');
            $personel->image = $response["image"]["way"];
        }
        if ($personel->save()) {
            $this->saveRestDay($personel, $request->restDay);
            $this->saveService($personel, $request->services);
            return to_route('personel.settings', $personel->id)->with('response', [
                'status' => "success",
                'message' => "Bilgileriniz Güncellendi",
            ]);
        }

    }

    public function saveRestDay($personel, $restDayId):void
    {
        $this->checkDayControl($personel);
        foreach ($restDayId as $day_id){
            $restDay = $personel->restDayAll()->where('day_id', $day_id)->first();
            if ($restDay){
                $restDay->status = 1;
                $restDay->save();
            }
        }
    }

    public function checkDayControl($personel):void
    {
        if ($personel->restDayAll->count() == 0){
            $dayList = DayList::all();
            foreach ($dayList as $day){
                $newRestDay = new PersonelRestDay();
                $newRestDay->personel_id = $personel->id;
                $newRestDay->day_id = $day->id;
                $newRestDay->status = 0;
                $newRestDay->save();
            }
        }

    }
    public function saveService($personel, $services):void
    {
        foreach ($services as $serviceId) {
            $existPersonelService = $personel->services()->where('service_id', $serviceId)->first();
            if (!$existPersonelService){
                $personelService = new PersonelService();
                $personelService->service_id = $serviceId;
                $personelService->personel_id = $personel->id;
                $personelService->save();
            }
        }
        $personel->services()->whereNotIn('service_id', $services)->delete();
    }

    public function notificationPermission()
    {
        $permissions = authUser()->permission;
        return view('personel.notification-permission.index', compact('permissions'));
    }

    public function notificationPermissionUpdate(Request $request)
    {
        $notificationPermission = authUser()->permission;
        $notificationPermission->{$request->column} = !$notificationPermission->{$request->column};
        if ($notificationPermission->save()){
            return response()->json([
                'status' => "success",
                'message' => "Bildirim Ayarlarınız Güncellendi",
            ]);
        }
    }


    public function passwordUpdate(BusinessOfficialPasswordUpdateRequest $request)
    {
        $user = authUser();
        $user->password = Hash::make($request->input('password'));
        if ($user->save()){
            return back()->with('response',[
                'status' => "success",
                'message' => "Şifreniz Güncellendi"
            ]);
        }
    }
}
