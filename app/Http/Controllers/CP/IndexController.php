<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Http\Helper\NewRequests;
use DB;
use stdClass;
use Auth;



class IndexController extends Controller
{

    /**
     * @var int $countMonths the number of months that will show in Charts
     * real months will be $countMonths + 1 because current month equals 0
     */
    private $countMonths = 7;

    /**
     * @var string first day of date that will be used in Charts
     * I use it to filter data by start data (date from)
     */
    private $countMonthsDate;

    /**
     * @var array $chartData to save data that will be used in Charts
     */
    private $chartData = [];

    /**
     * @var string $queryToGetSumAndCount to save sql sub-queries that will be used to get sum and count
     */
    private $queryToGetSumAndCount = [];

    public function __construct()
    {
        $this->countMonthsDate = date('Y-m-01', strtotime("-$this->countMonths months"));
    }

    /**
     * Display a listing of the resource.
     */
    public function indexCP()
    {
        if (!hasRole('trips_show') || !hasRole('shipping_invoices_show') || !hasRole('messages_show') || !hasRole('customers_show')) {
            /* if user dosen't have permissions , so show to him welcome page */
            return view('CP.welcome');
        }

        $this->AddTable('trips', 'cost', ' `state` = 3 ', 'arrived_at');
        $this->AddTable('shipping_invoices', 'total_cost', ' `received_at` IS NOT NULL ', 'received_at');

        $sum = $this->getSumAndCount();

        return view("CP.welcome");
    }

    /**
     * Add Table that will be used in Charts
     *
     * @param string $table Name of table
     * @param string $sumColumn Name Of column that will be used to get SUM
     * @param string $condition (WHERE) condition thata will be used to filter data
     * @param string $dateColumn Name Of column that will be used to calculate date
     */
    private function AddTable($table, $sumColumn, $condition, $dateColumn)
    {
        $this->queryToGetSumAndCount[] = $this->getSumAndCountQuery($table, $sumColumn, $condition);
        $this->chartData[$table] = $this->getChartData($table, $sumColumn, $condition, $dateColumn);
    }

    /**
     * Get values with total and percentages
     *
     * @return object
     */
    private function getSumAndCount()
    {
        $sum = DB::select('SELECT * FROM ' . implode(',', $this->queryToGetSumAndCount));
        $sum = $sum[0];

        $sumTotal = 0; /* to save sum of (column) sum property in array */
        $countTotal = 0; /* to save sum of count property in array */
        $percentage = new stdClass; /* to save percentages for all items */

        foreach ($sum as $key => $value) {
            $sum->$key = (float) $value;
            ends_with($key, '_sum') ? $sumTotal += $value : $countTotal += $value;
        }

        foreach ($sum as $key => $value) {
            if ($value == 0) {
                $percentage->$key = 0;
            } else {
                $percentage->$key = round($value / (ends_with($key, '_sum') ? $sumTotal : $countTotal) * 100, 1);
            }
        }

        $sum->total_sum = $sumTotal;
        $sum->total_count = $countTotal;
        $sum->percentage = $percentage;

        return $sum;
    }

    /**
     * Get Sql query to get sum and count values for specific table
     *
     * @param string $table Name of table
     * @param string $sumColumn Name Of column that will be used to get SUM
     * @param string $condition (WHERE) condition thata will be used to filter data
     */
    private function getSumAndCountQuery($table, $sumColumn, $condition)
    {
        return "(SELECT IFNULL(SUM($sumColumn),0) AS `{$table}_sum`, COUNT(*) AS `{$table}_count` FROM `$table` WHERE $condition ) AS `$table`";
    }

    /**
     * Get Data for Charts for specific dates
     *
     * @param string $table Name of table
     * @param string $sumColumn Name Of column that will be used to get SUM
     * @param string $condition (WHERE) condition thata will be used to filter data
     * @param string $dateColumn Name Of column that will be used to calculate date
     */
    private function getChartData($table, $sumColumn, $condition, $dateColumn)
    {
        return $this->getArrayWithAllMonths(

            DB::select(" SELECT COUNT(*) AS `count`, SUM(`$sumColumn`) AS `sum` ,YEAR(`$dateColumn`) AS `year`,MONTH(`$dateColumn`) AS `month` FROM `$table`
                WHERE  $condition AND DATE(`$dateColumn`) >= '$this->countMonthsDate'
                GROUP BY YEAR(`$dateColumn`) ,MONTH(`$dateColumn`)
                ORDER BY year,month ASC
            ")

        );
    }

    /**
     * Get Array with all months for Charts and add month with value 0 if month is not exists in array
     *
     * @param array $items items array that will be checked
     * @return array array with all months
     */
    public function getArrayWithAllMonths($items)
    {
        $c_items = count($items);

        if ($c_items < $this->countMonths + 1) { /* maybe there is months dosen't exist , so I have to replace them by 0 */

            $newArry = array();
            $position = 0;
            $currentMonth = date('m', strtotime("-$this->countMonths month"));

            for ($i = 0; $i <= $this->countMonths; $i++) {

                if ($position < $c_items && $currentMonth == $items[$position]->month) {
                    $newArry[$i] = $items[$position++];
                } else {
                    $newArry[$i] = new stdClass;
                    $newArry[$i]->month = $currentMonth;
                    $newArry[$i]->count = 0;
                    $newArry[$i]->sum = 0;
                }

                $currentMonth == 12 ? $currentMonth = 1 : $currentMonth++;
            }

            return $newArry;
        }

        return $items;
    }

}
