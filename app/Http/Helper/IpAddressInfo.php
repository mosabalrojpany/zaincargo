<?php
namespace App\Http\Helper;

/**
 * Get inforation about ip address using ip-api
 */
class IpAddressInfo
{
    /**
     * Get information from ip (country , citry ..etc)
     *
     * @return Array
     */
    public static function get($ip = null)
    {
        if (empty($ip)) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));

        if ($query && $query['status'] == 'success') {
            $query['ip'] = $ip;
            return $query;
        } else {
            return [
                'status' => false,
                'country' => $ip,
                'city' => $ip,
                'ip' => $ip,
            ];
        }
    }

}
