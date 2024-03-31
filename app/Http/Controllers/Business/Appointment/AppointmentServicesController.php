<?php

namespace App\Http\Controllers\Business\Appointment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\AppointmentServiceAddRequest;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use App\Models\BusinessService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

/**
 * @group Appointment
 *
 */
class AppointmentServicesController extends Controller
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
     * Randevuya Hizmet Ekleme
     *
     * @param Request $request
     * @return Response
     */
    public function store(AppointmentServiceAddRequest $request, Appointment $appointment)
    {
        $lastService = $appointment->services()->latest('start_time')->first();
        $endTime = $lastService->end_time;
        $findService = BusinessService::find($request->service_id);

        $appointmentService = new AppointmentServices();
        $appointmentService->appointment_id = $appointment->id;
        $appointmentService->personel_id = $request->personel_id;
        $appointmentService->service_id = $request->service_id;
        $appointmentService->start_time = $endTime;
        $appointmentService->end_time = Carbon::parse($endTime)->addMinutes($findService->time);
        $appointmentService->save();

        return back()->with('response',[
            'status' => "success",
            'message' => "Randevuya Hizmet Eklendi"
        ]);
    }

    /**
     * Randevudan Hizmet Silme
     *
     * Burada dikkat etmen gereken randevudaki hizmetin id sini göndermeniz olacaktır url'de
     *
     */
    public function destroy(AppointmentServices $appointmentServices)
    {
        $serviceCount = $appointmentServices->appointment->services->count();
        if($serviceCount > 1){
            $appointmentServices->delete();
            return response()->json([
                'status' => "success",
                'message' => "Hizmet Bu Randevudan Kaldırıldı"
            ]);
        }
        return response()->json([
            'status' => "error",
            'message' => "Randevudaki Son Hizmeti Kaldıramazsınız"
        ]);
    }
}
