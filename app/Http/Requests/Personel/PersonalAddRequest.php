<?php

namespace App\Http\Requests\Personel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonalAddRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:personels',
            'phone' => 'required|unique:personels',
            'password' => 'required',
            'approve_type' => 'required',
            'restDay' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            //'food_start_time' => 'required',
            //'food_end_time' => 'required',
            'gender_type' => 'required',
            'rate' => 'required',
            'range' => 'required',
            'description' => 'nullable',
            'services' => 'required',
            'product_rate' => 'required',
            'is_case' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'avatar' => "Personel Görseli",
            'name' => 'Personel Adı',
            'email' => 'E-posta Adresi',
            'phone' => 'Telefon Numarası',
            'password' => 'Şifre',
            'approve_type' => 'Otomatik Onay Durumu',
            'restDay' => 'Tatil Günü',
            'start_time' => 'Başlangıç Saati',
            'end_time' => 'Bitiş Saati',
            //'food_start_time' => 'Yemek Başlangıç Saati',
            //'food_end_time' => 'Yemek Bitiş Saati',
            'gender_type' => 'Hizmet Verdiği Cinsiyet',
            'rate' => 'Hizmet Payı',
            'range' => 'Randevu Aralığı',
            'description' => 'Açıklama',
            'services' => 'Hizmetler',
            'product_rate' => "Satış Payı",
            'is_case' => "Kasa Yetki Durumu"
        ];
    }

    /*protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Eksik Alanlar Var',
            'errors' => $validator->errors()->all(),
        ], 422));
    }*/
}
