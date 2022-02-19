<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\CustomerWallet;
use App\Models\Customer;
use App\Models\internamltransfaremoney;
use App\Models\BranchesBank;
use App\Http\Requests\CleintTransfareMoneyRequest;
use Illuminate\Validation\ValidationException;

class InternalTransfareMoneyController extends Controller
{
    public function index()
    {
        $userid = authClient()->user()->code;
        $query = internamltransfaremoney::select()->where('from_customer', $userid)->orderBy('id')->latest();
        $data = CustomerWallet::select()->where('customer_id', authClient()->user()->id)->first();
        $branch = Branch::select()->get();
        $transfare = $query->paginate(25);
        return view('Client.internal_money_transfare.show', compact('transfare', 'data', 'branch'));
    }

    public function transfaremoney(CleintTransfareMoneyRequest $request)
    {
        $usercode = 'E'.$request->to_customer;
        $usertotransfare = Customer::select()->where('code', $usercode)->first();
        if ($usertotransfare['state'] == 3) {
            $userid = authClient()->user()->id;
            $data = CustomerWallet::select()->where('customer_id', $userid)->first();
            if(authClient()->user()->code == $usercode &&  $request->from_branch == $request->to_branch)
            {
                throw ValidationException::withMessages(['لا يمكنك تحويل الاموال لنفس العضوية في نفس الفرع']);
            }
            if($request->to_branch == 2){
                throw ValidationException::withMessages(['فرع مصراته غير متاح فالحوالات المالية الداخلية']);
            }
            $ifcost = $request->price + $this->earning($request->price);
            if ($request->from_branch == 1) {
                if ($request->curancy_type == 1) {
                    if ($data['money_denar_t'] >= $ifcost) {
                        $newinternaltransfare['from_customer'] = authClient()->user()->code;
                        $newinternaltransfare['to_customer'] = $usercode;
                        $newinternaltransfare['from_branch'] = $request->from_branch;
                        $newinternaltransfare['to_customer_id'] = $usertotransfare['id'];
                        $newinternaltransfare['from_customer_id'] = authClient()->user()->id;
                        $newinternaltransfare['to_branch'] = $request->to_branch;
                        $newinternaltransfare['price'] = $request->price;
                        $newinternaltransfare['curancy_type'] = 1;
                        $newinternaltransfare['note'] = $request->note;
                        $wather['money_denar_t'] = $data['money_denar_t'] - $ifcost;
                        internamltransfaremoney::create($newinternaltransfare);
                        $data->update($wather);
                        $this->minusfrombranchbanck(1,1,$ifcost);
                    }else{
                        throw ValidationException::withMessages(['القيمة الموجودة في حسابك لا تكفي']);
                                   }
                } elseif ($request->curancy_type == 2) {
                    if ($data['money_dolar_t'] >= $ifcost) {
                        $newinternaltransfare['from_customer'] = authClient()->user()->code;
                        $newinternaltransfare['to_customer'] = $usercode;
                        $newinternaltransfare['from_branch'] = $request->from_branch;
                        $newinternaltransfare['to_customer_id'] = $usertotransfare['id'];
                        $newinternaltransfare['from_customer_id'] = authClient()->user()->id;
                        $newinternaltransfare['to_branch'] = $request->to_branch;
                        $newinternaltransfare['price'] = $request->price;
                        $newinternaltransfare['curancy_type'] = 2;
                        $newinternaltransfare['note'] = $request->note;
                        $wather['money_dolar_t'] = $data['money_dolar_t'] - $ifcost;
                        internamltransfaremoney::create($newinternaltransfare);
                        $data->update($wather);
                        $this->minusfrombranchbanck(1,2,$ifcost);
                    }else{
                        throw ValidationException::withMessages(['القيمة الموجودة في حسابك لا تكفي']);
               }
                } else {
                    throw ValidationException::withMessages(['هناك خطأ ما في نوع العملة الرجاء المحاولة فيما بعد']);
                }
            } elseif ($request->from_branch == 2) {
                throw ValidationException::withMessages(['فرع مصراته غير متاح فالحوالات المالية الداخلية']);
                if ($request->curancy_type == 1) {
                    if ($data['money_denar_m'] >= $ifcost) {
                        $newinternaltransfare['from_customer'] = authClient()->user()->code;
                        $newinternaltransfare['to_customer'] = $usercode;
                        $newinternaltransfare['from_branch'] = $request->from_branch;
                        $newinternaltransfare['to_customer_id'] = $usertotransfare['id'];
                        $newinternaltransfare['from_customer_id'] = authClient()->user()->id;
                        $newinternaltransfare['to_branch'] = $request->to_branch;
                        $newinternaltransfare['price'] = $request->price;
                        $newinternaltransfare['curancy_type'] = 1;
                        $newinternaltransfare['note'] = $request->note;
                        $wather['money_denar_m'] = $data['money_denar_m'] - $ifcost;
                        internamltransfaremoney::create($newinternaltransfare);
                        $data->update($wather);
                        $this->minusfrombranchbanck(2,1,$ifcost);

                    }else{
                        throw ValidationException::withMessages(['القيمة الموجودة في حسابك لا تكفي']);
                                   }
                } elseif ($request->curancy_type == 2) {
                    if ($data['money_dolar_m'] >= $ifcost) {
                        $newinternaltransfare['from_customer'] = authClient()->user()->code;
                        $newinternaltransfare['to_customer'] = $usercode;
                        $newinternaltransfare['from_branch'] = $request->from_branch;
                        $newinternaltransfare['to_customer_id'] = $usertotransfare['id'];
                        $newinternaltransfare['from_customer_id'] = authClient()->user()->id;
                        $newinternaltransfare['to_branch'] = $request->to_branch;
                        $newinternaltransfare['price'] = $request->price;
                        $newinternaltransfare['curancy_type'] = 2;
                        $newinternaltransfare['note'] = $request->note;
                        $wather['money_dolar_m'] = $data['money_dolar_m'] - $ifcost;
                        internamltransfaremoney::create($newinternaltransfare);
                        $data->update($wather);
                        $this->minusfrombranchbanck(2,2,$ifcost);

                    }else{
                        throw ValidationException::withMessages(['القيمة الموجودة في حسابك لا تكفي']);
                                   }
                } else {
                    throw ValidationException::withMessages(['هناك خطأ ما في نوع العملة الرجاء المحاولة فيما بعد']);
                }
            } elseif ($request->from_branch == 3) {
                if ($request->curancy_type == 1) {
                    if ($data['money_denar_b'] >= $ifcost) {
                        $newinternaltransfare['from_customer'] = authClient()->user()->code;
                        $newinternaltransfare['to_customer'] = $usercode;
                        $newinternaltransfare['from_branch'] = $request->from_branch;
                        $newinternaltransfare['to_customer_id'] = $usertotransfare['id'];
                        $newinternaltransfare['from_customer_id'] = authClient()->user()->id;
                        $newinternaltransfare['to_branch'] = $request->to_branch;
                        $newinternaltransfare['price'] = $request->price;
                        $newinternaltransfare['curancy_type'] = 1;
                        $newinternaltransfare['note'] = $request->note;
                        $wather['money_denar_b'] = $data['money_denar_b'] - $ifcost;
                        internamltransfaremoney::create($newinternaltransfare);
                        $data->update($wather);
                        $this->minusfrombranchbanck(3,1,$ifcost);
                    }else{
                        throw ValidationException::withMessages(['القيمة الموجودة في حسابك لا تكفي']);
                                        }
                } elseif ($request->curancy_type == 2) {
                    if ($data['money_dolar_b'] >= $ifcost) {
                        $newinternaltransfare['from_customer'] = authClient()->user()->code;
                        $newinternaltransfare['to_customer'] = $usercode;
                        $newinternaltransfare['from_branch'] = $request->from_branch;
                        $newinternaltransfare['to_customer_id'] = $usertotransfare['id'];
                        $newinternaltransfare['from_customer_id'] = authClient()->user()->id;
                        $newinternaltransfare['to_branch'] = $request->to_branch;
                        $newinternaltransfare['price'] = $request->price;
                        $newinternaltransfare['curancy_type'] = 2;
                        $newinternaltransfare['note'] = $request->note;
                        $wather['money_dolar_b'] = $data['money_dolar_b'] - $ifcost;
                        internamltransfaremoney::create($newinternaltransfare);
                        $data->update($wather);
                        $this->minusfrombranchbanck(3,2,$ifcost);

                    }else{
                        throw ValidationException::withMessages(['القيمة الموجودة في حسابك لا تكفي']);
                                   }
                } else {
                    throw ValidationException::withMessages(['هناك خطأ ما في نوع العملة الرجاء المحاولة فيما بعد']);
                }
            } else {
                throw ValidationException::withMessages(['هناك خطأ ما فالفروع الرجاء المحاولة فيما بعد']);
            }
        } else {
            throw ValidationException::withMessages(['يمكن ان يكون حساب الزبون مغلق او غير فعال الرجاء التاكد قبل التحويل']);
        }
    }

    private function earning($price)
    {

         if ($price <= 1015 && $price >= 20) {
            return 15;
        } elseif ($price <= 2030 && $price >= 1016) {
            return 30;
        } elseif ($price <= 3045 && $price >= 2016) {
            return 45;
        } elseif ($price <= 4060 && $price >= 3016) {
            return 60;
        } elseif ($price <= 5075 && $price >= 4016) {
            return 75;
        } elseif ($price <= 6090 && $price >= 5016) {
            return 90;
        } elseif ($price <= 7105 && $price >= 6016) {
            return 105;
        } elseif ($price <= 8115 && $price >= 7016) {
            return 115;
        } elseif ($price <= 9130 && $price >= 8016) {
            return 130;
        } elseif ($price <= 10145 && $price >= 9016) {
            return 145;
        } elseif ($price <= 11160 && $price >= 10016) {
            return 160;
        } elseif ($price <= 12175 && $price >= 11016) {
            return 175;
        } elseif ($price <= 13190 && $price >= 12016) {
            return 190;
        } elseif ($price <= 14205 && $price >= 13016) {
            return 205;
        } elseif ($price <= 15215 && $price >= 14016) {
            return 215;
        } elseif ($price <= 16230 && $price >= 15016) {
            return 230;
        } elseif ($price <= 17245 && $price >= 16016) {
            return 245;
        } elseif ($price <= 18260 && $price >= 17016) {
            return 260;
        } elseif ($price <= 19275 && $price >= 18016) {
            return 275;
        } elseif ($price <= 20290 && $price >= 19016) {
            return 290;
        } elseif ($price <= 21305 && $price >= 20016) {
            return 305;
        } elseif ($price <= 22315 && $price >= 21016) {
            return 315;
        } elseif ($price <= 23330 && $price >= 22016) {
            return 330;
        } elseif ($price <= 24345 && $price >= 22016) {
            return 345;
        } elseif ($price <= 25360 && $price >= 22016) {
            return 360;
        } elseif ($price <= 26375 && $price >= 22016) {
            return 375;
        } elseif ($price <= 27390 && $price >= 22016) {
            return 390;
        } elseif ($price <= 28405 && $price >= 22016) {
            return 405;
        } elseif ($price <= 29415 && $price >= 22016) {
            return 415;
        }elseif ($price <= 30430 && $price >= 22016) {
            return 430;
        }else{
            throw ValidationException::withMessages(['القيمة المدخلة غير متاحة']);

        }
    }

    private function minusfrombranchbanck($branche,$type,$price)
    {
        $query = BranchesBank::select()->where('branche_id',$branche)->first();
        if($type == 1)
        {
            $minus['Customer_balance_denar'] = $query['Customer_balance_denar']-$price;
            $query->update($minus);
        }if($type == 2)
        {
            $minus['Customer_balance_dolar'] = $query['Customer_balance_dolar']-$price;
            $query->update($minus);
        }
    }
}
