<?php
namespace App\Http\Helper;

use Auth;
use App\Models\Logins;
/**
 * UserSession Class to update user last access to server
 */
class UserSession
{

    /**
     * Update last access for session users
     */
    public static function update()
    {
        self::updateLastAccessUsers();
        if (session('idLog')) {
            Logins::where('id', session('idLog'))->update(['log_out' => new \DateTime()]);
        }
    }

    /**
     * Update last access for session users in table users
     */
    public static function updateLastAccessUsers()
    {
        $user = Auth::user();
        $user->last_access = new \DateTime();
        $user->save();
    }

}
