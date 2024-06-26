<?php

namespace App\Http\Requests\ProductSale;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductSaleUpdateRequest extends FormRequest
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
            "customer_id" => "required",//
            "product_id" => "required",//
            "personel_id" => "required",//
            "payment_type" => "required",//
            "amount" => "required",//
            "seller_date" => "required|date",//
        ];
    }

    public function attributes()
    {
        return [
            'customer_id' => 'Müşteri',
            'product_id' => 'Ürün',
            'personel_id' => 'Satıcı',
            'payment_type' => 'Ödeme Türü',
            'amount' => 'Satış Adedi',
            'seller_date' => 'Satış Tarihi',
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
