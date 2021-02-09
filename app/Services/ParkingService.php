<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

/**
 * Class ParkingService
 * @package App\Services
 */
class ParkingService
{

    /**
     * Cache clients location
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

        $clientLocation = Http::get('http://ip-api.com/json/' . $ip_address);

        if (!Cache::has('clientIpLocation')) {
            \cache()->remember('clientIpLocation', 60*60*24, function () use ($ip_address)
            {
                Http::get('http://ip-api.com/json/' . $ip_address)->body();
            });
//            Cache::put('clientIpLocation', $clientLocation->body(), 30000);
        }
    }

    /**
     * @param string $lat
     * @param string $lon
     * @param string $radius
     * @return mixed
     */
    public function getParkingPlaces(string $lat, string $lon, string $radius)
    {
        $sql_distance = "
         ,(((acos(sin((". $lat ."*pi()/180))
         * sin((`p`.`lat`*pi()/180))+cos((". $lat ."*pi()/180))
         * cos((`p`.`lat`*pi()/180)) * cos(((". $lon ."-`p`.`lng`)*pi()/180))))
         *180/pi())*60*1.1515*1.609344) as distance ";

        return DB::table('parkings as p')
            ->selectRaw('p.*' . $sql_distance)
            ->havingRaw('distance <= ' . $radius)
            ->orderBy('distance', 'ASC')
            ->paginate(5)->withQueryString();


//        $response = Http::get('http://localhost/GoodShape/public/api/getParking', [
//            'lat' => $lat,
//            'lon' => $lon,
//            'radius' => $radius
//        ]);

//        return json_decode($response);
    }
}
