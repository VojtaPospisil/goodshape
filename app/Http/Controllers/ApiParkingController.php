<?php

namespace App\Http\Controllers;

use App\Services\ApiServices\ApiParkingService;
use Illuminate\Http\Request;

class ApiParkingController extends Controller
{
    protected $apiParkingService;

    /**
     * ApiParkingController constructor.
     * @param ApiParkingService $apiParkingService
     */
    public function __construct(ApiParkingService $apiParkingService)
    {
        $this->apiParkingService = $apiParkingService;
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function getParkingLocations(Request $request)
    {
        return $this->apiParkingService->getApiParkingPlaces($request);
    }
}
