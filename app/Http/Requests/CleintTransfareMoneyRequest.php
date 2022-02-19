<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\internamltransfaremoney;

class CleintTransfareMoneyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
            return [
                'from_branch' => 'required|numeric|digits_between:1,10000000',
                'to_branch' => 'required|numeric|between:1,100000000',
                'curancy_type' => 'required|numeric|between:0,2',
                'to_customer' => 'required|numeric|between:1,10000000000',
                'price' => 'required|numeric|between:0,10000000.000000000',
                'note' => 'min:0|max:1000',
            ];


    }

    public function messages()
    {
        return [
            'to_customer.numeric' => 'كود الزبون يجب ان يحتوي على ارقام',
                ];
     }
}
