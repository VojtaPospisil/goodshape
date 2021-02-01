<?php


namespace App\Services\ApiServices;

use Illuminate\Support\Facades\DB;

/**
 * Class ApiParkingService
 * @package App\Services\ApiServices
 */
class ApiParkingService
{
    /**
     * @param $request
     * @return false|string
     */
    public function getApiParkingPlaces($request)
    {
        $sql_distance = "
         ,(((acos(sin((". $request->lat ."*pi()/180))
         * sin((`p`.`lat`*pi()/180))+cos((". $request->lat ."*pi()/180))
         * cos((`p`.`lat`*pi()/180)) * cos(((". $request->lon ."-`p`.`lng`)*pi()/180))))
         *180/pi())*60*1.1515*1.609344) as distance ";

        $response = DB::table('parkings as p')
            ->selectRaw('p.*' . $sql_distance)
            ->havingRaw('distance <= ' . $request->radius)
            ->orderBy('distance', 'ASC')
            ->paginate(5)->withQueryString();

        return json_encode($response);
    }
}
