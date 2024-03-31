<?php

namespace App\Http\Requests\Adission;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CashPointUseRequest extends FormRequest
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
            "cashpoint_id" => "required",
        ];
    }

    public function attributes()
    {
        return [
            'cashpoint_id' => 'Parapuan seçimi',
        ];
    }

}
