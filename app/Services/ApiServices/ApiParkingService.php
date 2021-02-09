<?php

namespace App\Services\ApiServices;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Class ApiParkingService
 * @package App\Services\ApiServices
 */
class ApiParkingService
{
    /**
     * Cache clients location
     *
     * @return mixed
     */
    public function getClientIpLocation()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip_address = $_SERVER['HTTP_CLIENT_IP'];
        } //whether ip is from proxy
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } //whether ip is from remote address
        else {
//            $ip_address = $_SERVER['SERVER_ADDR'];
            $ip_address = '89.177.137.176';
        }

        if (!Cache::has('clientIpLocation')) {
            $clientLocation = Http::get('http://ip-api.com/json/' . $ip_address);
            Cache::put('clientIpLocation', $clientLocation->body(), 30000);
        }

        return Cache::get('clientIpLocation');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Support\Collection
     */
    public function getApiParkingPlaces(Request $request)
    {
        $gpsData = array();
        if ($request->gps) {
            $gpsData = explode(',', str_replace(' ', '', $request->gps));
        } else {
            $gps = json_decode(Cache::get('clientIpLocation'));
            $gpsData[0] = $gps->lat;
            $gpsData[1] = $gps->lon;
        }

        $sql_distance = "
         ,(((acos(sin((". $gpsData[0] ."*pi()/180))
         * sin((`p`.`lat`*pi()/180))+cos((". $gpsData[0] ."*pi()/180))
         * cos((`p`.`lat`*pi()/180)) * cos(((". $gpsData[1] ."-`p`.`lng`)*pi()/180))))
         *180/pi())*60*1.1515*1.609344) as distance,";


        $response = DB::table('parkings as p')
            ->selectRaw('p.name' . $sql_distance . ' p.totalNumOfPlaces, p.numOfFreePlaces')
            ->havingRaw('distance <= ' . $request->radius);

        $response->when($request->has('name'), function ($query) use ($request) {
            $query->orderBy('name', $request->name);
        });

        $response->when($request->has('distance'), function ($query) use ($request) {
            $query->orderBy('distance', $request->distance);
        });

        $response->when($request->has('numOfFreePlaces'), function ($query) use ($request) {
            $query->orderBy('numOfFreePlaces', $request->numOfFreePlaces);
        });

        $response->when($request->has('searchName'), function ($query) use ($request) {
            $query->where('name', 'LIKE', '%' . $request->searchName . '%');
        });

        return collect($response->paginate(5));
    }
}
