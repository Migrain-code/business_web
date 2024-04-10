<?php

namespace App\Http\Requests\Promossion;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PromosionUpdateRequest extends FormRequest
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
            'cash' => ['required', 'numeric', 'between:0,100'],
            'credit' => ['required', 'numeric', 'between:0,100'],
            'eft' => ['required', 'numeric', 'between:0,100'],
            'use_limit' => ['required'],
            'birthday'=> ['required', 'numeric', 'between:0,100'],
        ];
    }

    public function attributes()
    {
        return [
            'cash' => 'Nakit Ödeme Promosyonu',
            'credit' => 'Kredi Kartı Ödeme Promosyonu',
            'eft' => 'EFT/Havale Promosyonu',
            'use_limit' => 'Parapuan Kullanım Limiti',
            'birthday' => 'Doğum Günü İndirimi Promosyonu',
        ];
    }

}
