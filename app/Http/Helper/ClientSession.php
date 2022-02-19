<?php
namespace App\Http\Helper;

use App\Models\ClientLogin;

/**
 * ClientSession Class to update client last access to server
 */
class ClientSession
{

    /**
     * Update last access for session client
     */
    public static function update()
    {
        self::updateLastAccessClient();
        if (session('clientIdLog')) {
            ClientLogin::where('id', session('clientIdLog'))->where('customer_id', authClient()->user()->id)->update(['log_out' => new \DateTime()]);
        }
    }

    /**
     * Update last access for session client in table customers
     */
    public static function updateLastAccessClient()
    {
        $client = authClient()->user();
        $client->last_access = new \DateTime();
        $client->save();
    }

}
