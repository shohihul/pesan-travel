<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\DoorToDoorServiceRepository;

class DoorToDoorServiceController extends Controller
{
    private $doorToDoorServiceRepository;

    public function __construct(DoorToDoorServiceRepository $doorToDoorServiceRepository)
    {
        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
    }

    public function route_index()
    {
        $route = $this->doorToDoorServiceRepository->get_route();

        return response()->json(['data' => $route], 200);
    }

    public function route_schedule_index($origin_id, $destination_id)
    {
        $schedule = $this->doorToDoorServiceRepository->get_by_origin_destination_id($origin_id, $destination_id);

        return response()->json(['data' => $schedule], 200);
    }
}
