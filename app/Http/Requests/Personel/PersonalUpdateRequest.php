<?php

namespace App\Http\Requests\Personel;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonalUpdateRequest extends FormRequest
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
            //'email' => 'required',
            'phone' => 'required',
            'approve_type' => 'required',
            //'restDay' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'food_start_time' => 'nullable',
            'food_end_time' => 'nullable',
            'gender_type' => 'required',
            'range' => 'required',
            'description' => 'nullable',
            //'is_case' => 'required',
        ];
    }

    public function attributes()
    {

        return [
            'name' => 'Personel Adı',
            'email' => 'E-posta Adresi',
            'phone' => 'Telefon Numarası',
            'approve_type' => 'Otomatik Onay Durumu',
            //'restDay' => 'Tatil Günü',
            'start_time' => 'Başlangıç Saati',
            'end_time' => 'Bitiş Saati',
            'food_start_time' => 'Yemek Başlangıç Saati',
            'food_end_time' => 'Yemek Bitiş Saati',
            'gender_type' => 'Hizmet Verdiği Cinsiyet',
            'rate' => 'Hizmet Payı',
            'range' => 'Randevu Aralığı',
            'description' => 'Açıklama',
            'product_rate' => "Satış Payı",
            //'is_case' => "Kasa Yetki Durumu"
        ];
    }
}
