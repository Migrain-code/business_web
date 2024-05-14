<?php

namespace App\Http\Requests\Service;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceAddRequest extends FormRequest
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
            'typeId' => 'required',
            'categoryId' => 'required',
            'subCategoryId' => 'required',
            'time' => 'required',
            'price_type_id' => 'required',
            'price' => 'nullable',
            'min_price' => 'required_if:price_type_id,2',
            'max_price' => 'required_if:price_type_id,2',
        ];
    }

    public function attributes()
    {
        return [
            'typeId' => 'Cinsiyet',
            'categoryId' => 'Kategori',
            'subCategoryId' => 'Hizmet',
            'time' => 'Süre',
            'price_type_id' => 'Fiyat Türü',
            'price' => 'Fiyat',
            'min_price' => 'Minimum Fiyat',
            'max_price' => 'Maksimum Fiyat',
        ];
    }
    protected function withValidator($validator)
    {
        /*$validator->sometimes('price', 'required', function ($input) {
            return $input->price_type_id == 1;
        });*/
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
