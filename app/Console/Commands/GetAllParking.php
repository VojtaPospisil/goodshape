<?php

namespace App\Console\Commands;

use App\Services\GetParkingService;
use Illuminate\Console\Command;

class GetAllParking extends Command
{
    /**
     * @var GetParkingService
     */
    private $parkingService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'getallparking:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @param GetParkingService $getParkingService
     */
    public function __construct(GetParkingService $getParkingService)
    {
        parent::__construct();
        $this->parkingService = $getParkingService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->parkingService->getAllParking();
    }
}
