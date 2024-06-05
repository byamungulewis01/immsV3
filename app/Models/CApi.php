<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CApi extends Model
{
    /**
     * Auth(): Manage Token Access Provision
     * param1: $token: the token to check if it exists
     *
     * @param string $token
     * @return string
     */
    public static function auth($token = "")
    {
        $msg = [
            'status' => 'Failed',
            'message' => 'Denied',
            'namecompany' => '',
            'auth' => false,
        ];

        if (!empty($token)) {
            $result = Token::where('tokennumber', $token)->first();

            if ($result) {
                $msg['status'] = 'success';
                $msg['message'] = 'Authorized';
                $msg['namecompany'] = $result->namecompany;
                $msg['auth'] = true;
            } else {
                $msg['message'] = 'DB Invalid';
            }
        } else {
            $msg['message'] = 'Token Must Not Be Empty';
        }

        return json_encode($msg);
    }

    /**
     * country_id(): Transforms Country Code Into country Id IN our Databases
     * param1: $country_code: the country code To search In Db
     *
     * @param string $country_code
     * @return string
     */
    public static function country_id($country_code = "")
    {
        $msg = [
            'status' => 'Failed',
            'message' => 'Denied',
            'country_id' => '',
            'country_name' => '',
            'auth' => false,
        ];

        if (!empty($country_code)) {
            $result = Country::where('countsh', $country_code)->first();

            if ($result) {
                $msg['status'] = 'success';
                $msg['message'] = 'Authorized';
                $msg['country_id'] = $result->c_id;
                $msg['country_name'] = $result->countryname;
                $msg['auth'] = true;
            }
        } else {
            $msg['message'] = 'Invalid Country Code';
        }

        return json_encode($msg);
    }

    /**
     * country_price(): Computes Prices And returns Results
     * param1: $country_id: country ID
     * param2: $servty_id: Service type ID
     * param3: $weight_type: Weight type (e.g., 'g')
     * param4: $qty: Quantity for calculating its prices
     * param5: $country_code: the country code used
     *
     * @param int $country_id
     * @param int $servty_id
     * @param string $weight_type
     * @param int $qty
     * @param string $country_code
     * @return string
     */
    public static function country_price($country_id = '', $servty_id = '', $weight_type = '', $qty = '', $country_code = '')
    {
        $msg = [
            'status' => 'Failed',
            'message' => 'No zone Found',
            'zone_id' => '',
            'servty_id' => '',
            'weight_type' => '',
            'qty' => 0,
            'amount_unit' => '',
            'country_code' => $country_code,
        ];

        if (is_numeric($country_id)) {
            $result = czone::where('c_id', $country_id)->first();

            if ($result) {
                $msg['zone_id'] = $result->zone_id;

                if (is_numeric($servty_id) && is_numeric($qty)) {
                    $results = tarifs::where('zone_id', $msg['zone_id'])
                        ->where('servty_id', $servty_id)
                        ->where('type', $weight_type)
                        ->whereRaw("{$qty} between minweight AND maxweight")
                        ->first();

                    if ($results) {
                        $msg['status'] = 'success';
                        $msg['message'] = 'Tariffs found';
                        $msg['servty_id'] = $results->servty_id;
                        $msg['weight_type'] = $results->type;
                        $msg['qty'] = $qty;
                        $msg['amount_unit'] = $results->amount;
                    } else {
                        $msg['message'] = 'No Tariffs Found';
                    }
                } else {
                    $msg['message'] = 'Check If all fields have been filled';
                }
            }
        }

        return $msg;
    }

    /**
     * continent_price(): Computes Prices And returns Results based on continent
     * param1: $country_name: country name
     * param2: $servty_id: Service type ID
     * param3: $weight_type: Weight type (e.g., 'g')
     * param4: $qty: Quantity for calculating its prices
     * param5: $country_code: the country code used
     *
     * @param string $country_name
     * @param int $servty_id
     * @param string $weight_type
     * @param int $qty
     * @param string $country_code
     * @return string
     */
    public static function continent_price($country_name = '', $servty_id = '', $weight_type = '', $qty = '', $country_code = '')
    {
        $msg = [
            'status' => 'Failed',
            'message' => 'No Continent Found',
            'continent' => '',
            'servty_id' => '',
            'weight_type' => '',
            'qty' => 0,
            'amount_unit' => '',
            'country_code' => $country_code,
        ];

        if (!is_numeric($country_name)) {
            $result = continentw::whereRaw("LOWER(Country) = LOWER('{$country_name}')")->first();

            if ($result) {
                $msg['continent'] = $result->Continent;

                if (is_numeric($servty_id) && is_numeric($qty)) {
                    $results = ptarifcontinet::whereRaw("LOWER(cont_id) = LOWER('{$msg['continent']}')")
                        ->where('servty_id', $servty_id)
                        ->where('type', $weight_type)
                        ->whereRaw("{$qty} between minweight AND maxweight")
                        ->first();

                    if ($results) {
                        $msg['status'] = 'success';
                        $msg['message'] = 'Tariffs found';
                        $msg['servty_id'] = $results->servty_id;
                        $msg['weight_type'] = $results->type;
                        $msg['qty'] = $qty;
                        $msg['amount_unit'] = $results->amount;
                    } else {
                        $msg['message'] = 'No Tariffs Found';
                    }
                } else {
                    $msg['message'] = 'Check If all fields have been filled';
                }
            }
        }

        return $msg;
    }

    /**
     * single_country_price(): Computes Prices And returns Results based on single country
     * param1: $country_name: country name
     * param2: $weight_type: Weight type (e.g., 'g')
     * param3: $qty: Quantity for calculating its prices
     * param4: $country_code: the country code used
     *
     * @param string $country_name
     * @param string $weight_type
     * @param int $qty
     * @param string $country_code
     * @return string
     */
    public static function single_country_price($country_name = '', $weight_type = '', $qty = '', $country_code = '')
    {
        $msg = [
            'status' => 'Failed',
            'message' => 'No Country Tariffs Found',
            'weight_type' => '',
            'qty' => 0,
            'amount_unit' => '',
            'country_code' => $country_code,
        ];

        if (!is_numeric($country_name)) {
            if (!is_numeric($weight_type) && is_numeric($qty)) {
                $results = single_country_tarif::whereRaw("LOWER(countries) = LOWER('{$country_name}')")
                    ->where('type', $weight_type)
                    ->where('weight', $qty)
                    ->first();

                if ($results) {
                    $msg['status'] = 'success';
                    $msg['message'] = 'Tariffs found';
                    $msg['weight_type'] = $results->type;
                    $msg['qty'] = $qty;
                    $msg['amount_unit'] = $results->amount;
                } else {
                    $msg['message'] = 'No Tariffs Found';
                }
            } else {
                $msg['message'] = 'Check If all fields have been filled';
            }
        }

        return $msg;
    }
}
