<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParkingRequest;
use App\Services\ParkingService;
use Illuminate\Support\Facades\Cache;

class ParkingController extends Controller
{
    /**
     * @var ParkingService
     */
    private $parkingService;

    /**
     * ParkingController constructor.
     * @param ParkingService $parkingService
     */
    public function __construct(ParkingService $parkingService)
    {
        $this->parkingService = $parkingService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->parkingService->getClientIpLocation();

        return view('welcome');
    }

    /**
     * @param ParkingRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getParkingLocations(ParkingRequest $request)
    {
        $lat = $request->latitude;
        $lon = $request->longitude;

        if ($request->ip) {
            $json = json_decode(Cache::get('clientIpLocation'));
            $lat = $json->lat;
            $lon = $json->lon;
        }

        $clientLatLot = $lat . ',' .$lon;
        $parkingPlaces = $this->parkingService->getParkingPlaces($lat, $lon, $request->radius);

        return view('parking', compact('parkingPlaces', 'clientLatLot'));
    }
}
