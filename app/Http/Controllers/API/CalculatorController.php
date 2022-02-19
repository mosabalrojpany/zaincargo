<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CurrencyType;
use Illuminate\Http\Request;

class CalculatorController extends Controller
{

    /**
     * Shipping Address.
     * @var App\Models\Address
     */
    protected $address;

    /**
     * Currency.
     * @var App\Models\CurrencyType
     */
    protected $currency;

    /**
     * Shipping information which will be returned in response.
     * @var array
     */
    protected $data;

    /**
     * Calculate cost of shipment
     *
     * @param \Illuminate\Http\Response $request
     * @return \Illuminate\Http\Response
     */
    public function calculate(Request $request)
    {
        $this->validateData();

        $this->address = Address::select('id', 'type')->findOrFail($request->address);
        $this->currency = CurrencyType::select('id', 'name', 'sign', 'value')->findOrFail($request->currency);

        /* Start set info about shipment */
        $this->data['type'] = $this->address->getType();
        $this->data['currency'] = $this->currency->name;
        $this->data['currency_sign'] = $this->currency->sign;

        $this->data['length'] = $request->length;
        $this->data['width'] = $request->width;
        $this->data['height'] = $request->height;
        $this->data['weight'] = $request->weight;
        $this->data['Insurance'] = $request->Insurance * 1.5 / 100;

        $cubic_centimeter = $request->length * $request->width * $request->height;
        $this->data['volumetric_weight'] = round($cubic_centimeter / 5000, 3);
        $this->data['size'] = round($cubic_centimeter / 1000000, 3); // CBM : convert from cm^3 to m^3

        if ($this->address->type == 1) { // 1: Air freight

            if (($request->length + $request->width + $request->height > 150 && $this->data['volumetric_weight'] > $this->data['weight'])) {

                $this->calculateCost('volumetric_weight');

            } else {

                $this->calculateCost('weight');
            }

        } else if ($this->address->type == 2) { // 2: Sea freight

            $this->calculateCost('size');
        }
        /* End set info about shipment */

        return response()->json($this->data, 200);
    }

    /**
     * Calculate cost of shipment
     * @param string $weight key of weight or size in $data array
     */
    protected function calculateCost($weight)
    {
        if ($this->data[$weight] == 0) {
            $this->data['cost'] = 0;
        } else {
            $price = $this->getPrice($this->data[$weight]);
            if($this->data[$weight] >= 1)
            {
            $this->data['cost'] = ceil($this->data[$weight] * $price  +  $this->Insuranceprice($this->data['Insurance']));
            }
            elseif($this->data[$weight] < 1)
            {
                $this->data['cost'] = ceil($this->data[$weight] * $price  +  $this->Insuranceprice($this->data['Insurance']));
            }
        }
    }

    /**
     * Get the price of a kilo or CBM for a specific weight/Size
     * @param number $weight value of weight/size
     */
    protected function getPrice($weight)
    {
        $price = $this->address->prices()->select('price')
            ->where('from', '<=', $weight)
            ->where('to', '>=', $weight)
            ->first();
            
        $price = $price->price ?? null;
        

        /**
         * Sometimes user insert only one price and insert wrong range(from - to)
         * so when we try to get price we got no price because range does not exist
         * so we check if there is only one price it will be no different in cost
         * that means we can depends on it instead of return error
         */
        if (!$price && $this->address->prices()->count() === 1) {
            $price = $this->address->prices()->select('price')->first()->price;
        }

        /**
         * If sent(from request) currency equals main currency
         * that means we do not need to convert cost to any another currency
         * it will be same currency
         */
        if (app_settings()->currency_type_id === $this->currency->id) {

            return $price;
        }
        else
        {

        return round($price / $this->currency->value  , 3);
    }
}

    protected function Insuranceprice($shipmentprice)
    {
        if (app_settings()->currency_type_id === $this->currency->id) {
            return $shipmentprice;
        }
        else
        {
        $price2 = $this->data['Insurance'] / $this->currency->value;
        return $price2 ;
        }
    }



    /**
     * Validate Data
     */
    private function validateData()
    {
        $this->validate(request(), [
            'address' => 'required|integer',
            'currency' => 'required|integer',
            'length' => 'required|numeric|min:0.1',
            'width' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'weight' => 'required|numeric|min:0.001|max:1000000',
            'Insurance' => 'required|numeric|min:0|max:1000000',
        ], [], [
            'address' => 'عنوان الشحن',
        ]);
    }

}
