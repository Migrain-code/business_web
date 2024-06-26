<?php

namespace App\Http\Requests\Adission;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductSaleAddRequest extends FormRequest
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
            //"customer_id" => "required",
            "product_id" => "required",
            "personel_id" => "required",
            "payment_type_id" => "required",
            "amount" => "required",
            "price" => "required",
            //"date" => "required|date",
        ];
    }

    public function attributes()
    {
        return [
            //'customer_id' => 'Müşteri',
            'product_id' => 'Ürün',
            'personel_id' => 'Satıcı',
            'payment_type_id' => 'Ödeme Türü',
            'amount' => 'Satış Adedi',
            'price' => 'Satış Fiyatı',
            //'date' => 'Satış Tarihi'
        ];
    }

}
