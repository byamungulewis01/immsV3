<?php

namespace App\Http\Controllers;

use App\Models\CApi;
use Illuminate\Http\Request;

class PricingApiController extends Controller
{
    /**
     * Handle the request to get the price.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrice(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'token' => 'required',
            'country_code' => 'required',
            'servty_id' => 'required',
            'weight_type' => 'required',
            'qty' => 'required'
        ]);

        // Token Authentication
        $token = $request->input('token');
        $tokenAuth = json_decode(CApi::auth($token));
        $same_origin = false;

        // Check if the request is from the same origin
        if ($request->server('REQUEST_METHOD') == 'POST') {
            $referer = parse_url($request->server('HTTP_REFERER'));
            $origin = parse_url($request->server('HTTP_ORIGIN'));

            if (isset($referer['host']) && isset($origin['host']) && $referer['host'] === $origin['host']) {
                $same_origin = true;
            }
        }

        if ($tokenAuth->status == 'success' || $same_origin) {
            // Country Code to Country ID Translation
            $countryCode = $request->input('country_code');
            $countryId = json_decode(CApi::country_id(strtoupper($countryCode)));

            if ($countryId->status == 'success') {
                $countryId = $countryId->country_id;

                // Request Prices Info
                $servtyId = $request->input('servty_id');
                $weightType = $request->input('weight_type');
                $qty = $request->input('qty');

                // Display Result regarding Requested Price Info
                $result = CApi::country_price($countryId, $servtyId, $weightType, $qty, $countryCode);
                return response()->json($result);
            } else {
                // Inform user that the provided country code doesn't exist in the database
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Country does not exist'
                ]);
            }
        } else {
            // Inform user that the provided token is unauthorized or doesn't exist
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized'
            ]);
        }
    }

    /**
     * Handle the request to get the continent price.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContinentPrice(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'token' => 'required',
            'country_code' => 'required',
            'servty_id' => 'required',
            'weight_type' => 'required',
            'qty' => 'required'
        ]);

        // Token Authentication
        $token = $request->input('token');
        $tokenAuth = json_decode(CApi::auth($token));
        $same_origin = false;

        // Check if the request is from the same origin
        if ($request->server('REQUEST_METHOD') == 'POST') {
            $referer = parse_url($request->server('HTTP_REFERER'));
            $origin = parse_url($request->server('HTTP_ORIGIN'));

            if (isset($referer['host']) && isset($origin['host']) && $referer['host'] === $origin['host']) {
                $same_origin = true;
            }
        }

        if ($tokenAuth->status == 'success' || $same_origin) {
            // Country Code to Country Name Translation
            $countryCode = $request->input('country_code');
            $countryName = json_decode(CApi::country_id(strtoupper($countryCode)));

            if ($countryName->status == 'success' || 1==1) {
                $countryName = $countryName->country_name;

                // Request Continent Prices Info
                $servtyId = $request->input('servty_id');
                $weightType = $request->input('weight_type');
                $qty = $request->input('qty');

                // Display Result regarding Requested Continent Prices Info
                $result = CApi::continent_price($countryCode, $servtyId, $weightType, $qty, $countryCode);
                return response()->json($result);
            } else {
                // Inform user that the provided country code doesn't exist in the database
                return response()->json([
                    'status' => 'Failed',
                    'message' => 'Country does not exist'
                ]);
            }
        } else {
            // Inform user that the provided token is unauthorized or doesn't exist
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized'
            ]);
        }
    }

    /**
     * Handle the request to get the single country price.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSingleCountryPrice(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'token' => 'required',
            'country_code' => 'required',
            'weight_type' => 'required',
            'qty' => 'required'
        ]);

        // Token Authentication
        $token = $request->input('token');
        $tokenAuth = json_decode(CApi::auth($token));
        $same_origin = false;

        // Check if the request is from the same origin
        if ($request->server('REQUEST_METHOD') == 'POST') {
            $referer = parse_url($request->server('HTTP_REFERER'));
            $origin = parse_url($request->server('HTTP_ORIGIN'));

            if (isset($referer['host']) && isset($origin['host']) && $referer['host'] === $origin['host']) {
                $same_origin = true;
            }
        }

        if ($tokenAuth->status == 'success' || $same_origin) {
            // Country Code
            $countryCode = $request->input('country_code');

            // Request Single Country Price Info
            $weightType = $request->input('weight_type');
            $qty = $request->input('qty');

            // Display Result regarding Requested Single Country Price Info
            $result = CApi::single_country_price($countryCode, $weightType, $qty, $countryCode);
            return response()->json($result);
        } else {
            // Inform user that the provided token is unauthorized or doesn't exist
            return response()->json([
                'status' => 'Failed',
                'message' => 'Unauthorized'
            ]);
        }
    }

    /**
     * Handle the request for unknown services.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unknownService()
    {
        // Inform the user that the requested service doesn't exist
        return response()->json([
            'status' => 'Failed',
            'message' => 'Unknown Service'
        ]);
    }

    /**
     * Handle the request for unknown methods.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function unknownMethod()
    {
        // Inform the user that the requested method doesn't exist
        return response()->json([
            'status' => 'Failed',
            'message' => 'Unknown Method'
        ]);
    }
}
