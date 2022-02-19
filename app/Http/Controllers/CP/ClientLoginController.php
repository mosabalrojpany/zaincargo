<?php

namespace App\Http\Controllers\CP;

use App\Models\ClientLogin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientLoginController extends Controller
{
    /**
     * Logins for clients
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'code' => 'nullable|integer',
            'show' => 'nullable|numeric|max:1000',
        ]);

        $paginate = 25;
        $query = ClientLogin::with('customer:id,name,code');

        if ($request->search) {
            if ($request->from) {
                $query->whereDate('log_in', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('log_in', '<=', $request->to);
            }
            if ($request->code) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('code', get_customer_code_starts_with() . $request->code);
                });
            }
            if ($request->show) {
                $paginate = $request->show;
            }
        }

        $logins = $query->latest('log_in')->paginate($paginate);

        $logins->appends($request->query());

        return view('CP.clients_logins', [
            'logins' => $logins,
        ]);
    }
}
