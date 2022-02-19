<?php

namespace App\Http\Requests\CP;

use Illuminate\Foundation\Http\FormRequest;

class MarchentInvoiceRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
            return [
                'marchent_id' => 'required|numeric|digits_between:1,10000000',
            ];


    }

    public function messages()
    {
        return [
            'marchent_id.numeric' => 'كود الزبون يجب ان يحتوي على ارقام',
                ];
     }
}
