<?php
namespace App\Http\Helper;

use DB;

/**
 *  New Orders Requests that sended from clients and visitors in application
 */
class NewRequests
{

    /**
     * The instance(object) of NewRequests.
     *
     * @var static
     */
    protected static $instance;

    /**
     * Requests data.
     */
    protected $requests;

    public function __construct()
    {
        $this->requests = $this->getNewRequestsFromDB();
    }

    /**
     * Get Requests
     * @return static
     */
    public function getRequests()
    {
        return $this->requests;
    }

    /**
     * Get new requests from Database
     */
    protected function getNewRequestsFromDB()
    {
        $query = [];

        if (hasRole('shipment_comments_show')) {
            $query[] = $this->getStateQuery('shipment_comments', true, 'unread', ' AND `user_id` IS NULL');
        }

        if (hasRole('customers_show')) {
            $query[] = $this->getStateQuery('customers', 1);
        }

        if (hasRole('messages_show')) {
            $query[] = $this->getStateQuery('messages', true, 'unread');
        }

        if (!empty($query)) {

            $notifications = DB::select('SELECT ' . implode(',', $query));

            return $notifications[0];
        }
    }

    /**
     * Get sql query to get count of new states of specific table.
     *
     * @param string $table name of table
     * @param string $state state that will be get his count
     * @param string $stateColumn column that will be used to specify state
     * @param string $extraCondation extra condition to filter query
     * @return string
     */
    protected function getStateQuery($table, $state, $stateColumn = 'state', $extraCondation = '')
    {
        return "(SELECT COUNT(*) FROM `$table` WHERE `$stateColumn` = $state  $extraCondation ) AS `$table`";
    }

    /**
     * Get the instance of the current class.
     *
     * @return static
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}
