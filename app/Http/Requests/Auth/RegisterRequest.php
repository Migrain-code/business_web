<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255', 'unique:business_officials'],
            'business_name' => ['required', 'string', 'max:255'],
            'terms_and_contitions' => ['accepted'],
            'privacy_terms' => ['accepted'],
            'clarification' => ['accepted'],
        ];
    }

    public function attributes()
    {
        return [
            'name' => "Salon Sahibinin Adı",
            'phone' => "Telefon Numarası",
            'business_name' => "İşletme adı",
            'terms_and_contitions' => "Şartlar ve Koşullar",
            'privacy_terms' => "Gizlilik Koşulları",
            'clarification' => "Aydınlatma Metni",
        ];
    }
}
