<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Http\Helper\UserSession;
use App\Models\Logins;
use App\Models\User;
use Auth;
use Browser;
use Hash;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginsController extends Controller
{

    use ThrottlesLogins;

    protected $maxAttempts = 5;
    protected $decayMinutes = 5;

    /**
     * Get the login username to be used by the controller (ThrottlesLogins).
     *
     * @return string
     */
    public function username()
    {
        return 'username';
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
            'username' => 'required|string|min:3|max:32',
            'password' => 'required|string|min:6|max:32',
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $failedMsg = array();

        $user = User::select('id', 'name', 'password', 'active')->where('username', request('username'))->first();

        if ($user) {
            if (Hash::check(request('password'), $user->password)) {

                if ($user->active) {
                    //if(auth()->attempt(['email' => request('email'), 'password' => request('password') , 'active' => 1])){
                    auth()->login($user, $request->filled('remember'));

                    $request->session()->regenerate();
                    $this->clearLoginAttempts($request);

                    $this->startSession();

                    return response()->json([
                        'success' => true,
                        'redirectTo' => url('/cp/index'),
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
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request, $failedMsg);
    }

    /**
     * Start seesion for user and update last_login.
     */
    public function startSession()
    {
        UserSession::updateLastAccessUsers();

        $ip_info = \App\Http\Helper\IpAddressInfo::get();

        $id = Logins::insertGetId([
            'ip' => $ip_info['ip'],
            'country' => $ip_info['country'],
            'city' => $ip_info['city'],
            'user_id' => Auth::user()->id,
            'os' => Browser::platformName(),
            'browser' => Browser::browserFamily(),
        ]);

        session(['idLog' => $id]);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function logout()
    {
        Auth::logout();
        return redirect('cp/login');
    }

    /**
     * Logins for users
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'user' => 'nullable|numeric',
            'show' => 'nullable|numeric|max:1000',
        ]);

        $paginate = 25;
        #$query = Logins::join('users', 'users.id', '=', 'logins.user_id')->select('logins.*', 'users.name');
        $query = Logins::with('user');

        if ($request->search) {
            if ($request->from) {
                $query->whereDate('log_in', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('log_in', '<=', $request->to);
            }
            if ($request->user) {
                $query->where('user_id', $request->user);
            }
            if ($request->show) {
                $paginate = $request->show;
            }
        }

        $logins = $query->orderBy('log_in', 'DESC')->paginate($paginate);
        #$users = Logins::join('users', 'users.id', '=', 'logins.user_id')->select('users.id', 'users.name')->distinct()->get();
        $users = User::select('id', 'name')->get();

        $logins->appends([
            'from' => $request['from'],
            'to' => $request['to'],
            'user' => $request['user'],
            'show' => $request['show'],
            'search' => $request['search'],
        ]);

        return view('CP.logins', [
            'logins' => $logins,
            'users' => $users,
        ]);
    }

}
