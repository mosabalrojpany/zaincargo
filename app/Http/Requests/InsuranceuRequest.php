<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ShippingInvoice;

class InsuranceuRequest extends FormRequest
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
        if($this->id == $this->oldid)
        {
            if(ShippingInvoice::find($this->id))
            {
        return [
            'id' => 'required|numeric|digits_between:1,10000000',
            'Insurance' => 'required|numeric|between:0,10000000.000000000',
        ];
    }
    else
    {
        return [
            'id'=>'error2'
        ];
    }
    }
    else
    {
        return [
        'id'=>'error1'
    ];
    }
    }

     public function messages()
        {
            return [
                                'id.error1' => 'هناك خطأ ما يرجى المحاولة فيما بعد',
                                'id.error2' => 'لا يوجد فاتورة بهدا المعرف',
                                'required' => 'هدا الحقل مطلوب',
                        // numeric
                                'id.numeric' => 'هدا الحقل يجب ان يكون ارقام',
                                'Insurance.numeric' => 'هدا الحقل يجب ان يكون ارقام',
                        //  end numeric



                        //  MAX
                                'id.max'=>'يجب الا يتجاوز عدد الاحرف ال255 حرف',
                                'Insurance.max'=>'هناك خطأ ما يرجى المحاولة فيما بعد',
                        // END MAX

                        // digits_between
                                'id.digits_between' => 'الرقم كبير جدا',
                                'Insurance.between' => 'الرقم كبير جدا',
                        // END digits_between
                    ];
         }
}
