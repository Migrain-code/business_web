<?php

namespace App\Http\Requests\Business;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusinessInfoUpdateRequest extends FormRequest
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
            "approve_type" => 'required',
            "off_day" => 'required',
            "start_time" => 'required',
            "end_time" => 'required',
            "name" => 'required',
            "email" => 'required',
            "phone" => 'required',
            "range" => 'required',
            "city_id" => 'required',
            "district_id" => 'required',
            "category_id" => 'required',
            "type_id" => 'required',
            "team_size" => 'required',
            'about_content' => "required",
        ];
    }

    public function attributes()
    {
        return [
            "approve_type" =>"Randevu Onay Türü",
            "off_day" => "Kapalı Gün",
            "start_time" => "Mesai Başlangıç Saati",
            "end_time" => "Mesai Bitiş Saati",
            "name" => "İşletme Adı",
            "email" => "İşletme Maili",
            "phone" => "İşletme Telefonu",
            "range" => "Randevu Aralığı",
            "city_id" => "Şehir",
            "district_id" => "İlçe",
            "category_id" => "İşletme Kategorisi",
            "type_id" => "Hizmet Verilen Cinsiyet",
            "team_size" => "Personel Sayısı",
            'about_content' => "İşletme Hakkında Yazısı",
        ];
    }

}
