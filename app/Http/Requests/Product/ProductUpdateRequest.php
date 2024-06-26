<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductUpdateRequest extends FormRequest
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
            'price' => 'required',
            'amount' => 'required',
            'barcode' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Ürün Adı',
            'price' => 'Fiyat',
            'amount' => 'Adet',
            'barcode' => 'Ürün Kodu',
        ];
    }
}
