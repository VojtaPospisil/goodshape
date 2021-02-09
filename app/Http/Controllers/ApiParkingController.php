<?php

namespace App\Http\Controllers;

use App\Services\ApiServices\ApiParkingService;
use Illuminate\Http\Request;

/**
 * Class ApiParkingController
 * @package App\Http\Controllers
 */
class ApiParkingController extends Controller
{
    /**
     * @var ApiParkingService $apiParkingService
     */
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
     * @return mixed
     */
    public function getIpLocation()
    {
        return $this->apiParkingService->getClientIpLocation();
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
