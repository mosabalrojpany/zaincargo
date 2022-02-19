<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WalletStateRequest extends FormRequest
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
            'type' => 'required|numeric|min:1|max:2',
            'wallet_id' => 'required|numeric|digits_between:1,10000000',
            'curance_type_id' => 'required|numeric|digits_between:1,10000000',
            'price' => 'required|numeric|between:0.00,99999999.99',
            'note' => 'max:255',
            'branches_id' => 'required|numeric|digits_between:1,1',
        ];
    }

     public function messages()
        {
            return [

                                'required' => 'هدا الحقل مطلوب',
                        // numeric
                                'wallet_id.numeric' => 'هدا الحقل يجب ان يكون ارقام',
                                'curance_type_id.numeric' => 'هدا الحقل يجب ان يكون ارقام',
                                'branches_id.numeric' => 'هدا الحقل يجب ان يكون ارقام',
                                'price.numeric' => 'هدا الحقل يجب ان يكون ارقام',
                                'type.numeric' => 'هناك خطأ ما يرجى المحاولة فيما بعد',
                        //  end numeric
                        


                        //  MAX
                                'note.max'=>'يجب الا يتجاوز عدد الاحرف ال255 حرف',
                                'type.max'=>'هناك خطأ ما يرجى المحاولة فيما بعد',
                        // END MAX

                        // digits_between
                                'wallet_id.digits_between' => 'الرقم كبير جدا',
                                'curance_type_id.digits_between' => 'الرقم كبير جدا',
                                'branches_id.digits_between' => 'الرقم كبير جدا',
                                'price.between' => 'الرقم كبير جدا',
                        // END digits_between
                    ];
         }
}
