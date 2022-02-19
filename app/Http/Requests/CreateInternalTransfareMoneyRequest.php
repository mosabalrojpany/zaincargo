<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\transfarebranchbank;

class CreateInternalTransfareMoneyRequest extends FormRequest
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
        $branch = transfarebranchbank::firstWhere('branche_id',$this->branche_id);
        if($branch){
            return [
                'branche_id' => 'required|numeric|digits_between:1,10000000',
                'curance_type_id' => 'required|numeric|between:1,2',
                'price' => 'required|numeric|between:0,10000000.000000000',
                'note' => 'min:0|max:1000',
            ];
        }else{
            return [
                'error' => 'required',
            ];
        }

    }

    public function messages()
    {
        return [
                            'error.required' => 'هناك خطأ ما يرجى المحاولة فيما بعد',
                            'required' => 'هدا الحقل مطلوب',
                    // numeric
                            'numeric' => 'هدا الحقل يجب ان يكون ارقام',
                    //  end numeric
                            'price.between' => 'هناك خطأ ما فالقيمة',
                            'curance_type_id.between' => 'هناك خطأ ما في قيمة نوع العملة',


                    //  MAX
                            'note.max'=>'يجب الا يتجاوز عدد الاحرف ال1000 حرف',
                    // END MAX

                    // digits_between
                            'id.digits_between' => 'هناك خطأ ما في قيمة الفرع',
                    // END digits_between
                ];
     }
}
