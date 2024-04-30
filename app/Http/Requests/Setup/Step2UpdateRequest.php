<?php

namespace App\Http\Requests\Setup;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class Step2UpdateRequest extends FormRequest
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
            'team_size' => 'required',
            'business_name' => 'required',
            'business_type' => 'required',
            'business_phone' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'off_day_id' => 'required',
            'about_content' => 'required',
            'start_time' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'team_size' => 'Personel sayısı',
            'business_name' => 'İşletme Adı',
            'business_type' => 'İşletme Türü',
            'business_phone' => 'İşletme Telefon Numarası',
            'city_id' => 'Şehir',
            'district_id' => 'İlçe',
            'off_day_id' => 'Kapalı Olduğu Gün',
            'about_content' => 'İşletme Hakkında Yazısı',
            'start_time' => 'Mesai Başlangıç Saati',
            'end_time' => 'Mesai Bitiş Saati',
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
