<?php

namespace App\Http\Requests\Setup;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DetailSetupStep2UpdateRequest extends FormRequest
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
            'business_name' => 'required',
            'business_phone' => 'required',
            'off_day_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'appoinment_range' => 'required',
            //'image' => 'required|mimes:png,jpeg,jpg,webp|max:5120'
        ];
    }

    public function attributes()
    {
        return [
            'business_name' => 'İşletme Adı',
            'business_phone' => 'İşletme Telefon Numarası',
            'off_day_id' => 'Kapalı Olduğu Gün',
            'start_time' => 'Mesai Başlangıç Saati',
            'end_time' => 'Mesai Bitiş Saati',
            'appoinment_range' => "Randevu Aralığı",
            'image' => 'İşletme Logonuz'
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
