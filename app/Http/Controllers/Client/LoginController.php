<?php

namespace App\Http\Controllers\Client;

use App\Models\ClientLogin;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Browser;
use Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use ThrottlesLogins;

    protected $maxAttempts = 5;
    protected $decayMinutes = 5;

    /**
     * Get the login username to be used by the trait (ThrottlesLogins).
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request, $msg)
    {
        throw ValidationException::withMessages($msg);
    }

    /**
     *   Check info for login and add session if user logged
     *   Add new session login
     *   add session login in Database and save it in session user to update last access every request
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:32',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $failedMsg = array();

        $client = Customer::select('id', 'name', 'password', 'state')->where('email', request('email'))->first();

        if ($client) {

            if (Hash::check(request('password'), $client->password)) {

                if ($client->state == 3) { /* check if customer account is active */

                    authClient()->login($client, $request->filled('remember'));

                    $request->session()->regenerate();
                    $this->clearLoginAttempts($request);

                    $this->startSession();

                    return response()->json([
                        'redirectTo' => url('/client/index'),
                    ], 200);

                } else {

                    $failedMsg[] = 'هذا الحساب غير مفعل';

                }
            } else {

                $failedMsg[] = 'كلمة المرور غير صحيحة';

            }
        } else {

            $failedMsg[] = 'معلومات التسجيل غير صحيحة';

        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the client back to the login form. Of course, when this
        // client surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request, $failedMsg);
    }

    /**
     * Start seesion for client and update last_login.
     */
    public function startSession()
    {
        $ip_info = \App\Http\Helper\IpAddressInfo::get();

        $id = ClientLogin::insertGetId([
            'ip' => $ip_info['ip'],
            'country' => $ip_info['country'],
            'city' => $ip_info['city'],
            'customer_id' => authClient()->user()->id,
            'os' => Browser::platformName(),
            'browser' => Browser::browserFamily(),
        ]);

        session(['clientIdLog' => $id]);
    }

    /**
     * Log the client out of the application.
     */
    public function logout()
    {
        authClient()->logout();
        return redirect('/');
    }

}
