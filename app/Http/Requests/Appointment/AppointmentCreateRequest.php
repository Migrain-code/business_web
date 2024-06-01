<?php

namespace App\Http\Requests\Appointment;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AppointmentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => 'required',
            'personel_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'appointment_date' => 'required',
            'service_id' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'customer_id' => 'Müşteri Seçimi',
            'personel_id' => 'Personel Seçimi',
            'start_time' => 'Randevu Başlangıç Saati',
            'end_time' => 'Randevu Bitiş Saati',
            'appointment_date' => 'Randevu Tarihi',
            'service_id' => 'Hizmet Seçimi',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Eksik Alanlar Var',
            'errors' => $validator->errors()->all(),
        ], 422));
    }
}
