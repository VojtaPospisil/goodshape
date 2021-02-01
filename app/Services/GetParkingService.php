<?php

namespace App\Services;

use App\Parking;
use Illuminate\Support\Facades\Http;

class GetParkingService
{
    /**
     * @return bool
     */
    public function getAllParking()
    {
        $parkingPlaces = Http::get('http://www.tsk-praha.cz/tskexport3/json/parkings')['results'];

        foreach ($parkingPlaces as $parking) {
            $park = new Parking();
            $park->fill($parking);
            $park->save();
        }

        return true;
    }

}
