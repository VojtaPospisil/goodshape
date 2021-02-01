<?php

namespace App\Http\Controllers;

use App\Services\GetParkingService;

class CreateParkingController extends Controller
{
    protected $parkingService;

    /**
     * CreateParkingController constructor.
     * @param GetParkingService $getParkingService
     */
    public function __construct(GetParkingService $getParkingService)
    {
        $this->parkingService = $getParkingService;
    }

    public function seedParking()
    {
        $this->parkingService->getAllParking();
    }
}
