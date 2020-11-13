<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\DoorToDoorServiceRepository;
use App\Repositories\DoorToDoorOrderRepository;
use App\Repositories\CarRepository;

use App\Http\Resources\DoorToDoorServiceRouteCollection;
use App\Http\Resources\TaskDriver\ListTaskDriverCollection;
use App\Http\Resources\TaskDriver\TaskDriverItem;
use App\Http\Resources\Passenger\ListPassengerCollection;
use App\Http\Resources\DoorToDoorService\DoorToDoorServiceCollection;

class DoorToDoorServiceController extends Controller
{
    private $doorToDoorServiceRepository;
    private $doorToDoorOrderRepository;
    private $carRepository;

    public function __construct(DoorToDoorServiceRepository $doorToDoorServiceRepository, DoorToDoorOrderRepository $doorToDoorOrderRepository, CarRepository $carRepository)
    {
        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;
        $this->carRepository = $carRepository;
    }

    public function route_index()
    {
        $route = new DoorToDoorServiceRouteCollection($this->doorToDoorServiceRepository->get_route());

        return response()->json($route, 200);
    }

    public function route_schedule_index($origin_id, $destination_id)
    {
        $schedule = $this->doorToDoorServiceRepository->get_scheduled_by_route($origin_id, $destination_id);

        foreach ($schedule as $data) {
            $car_capacity = $this->carRepository->get_capacity($data['car_id']);
            $qty = $this->doorToDoorOrderRepository->get_qty_confirmed($data['id']);
            
            $data['available'] = $car_capacity-$qty;
        }

        return response()->json(new DoorToDoorServiceCollection($schedule), 200);
    }

    // public function schedule_show($doorToDoorService_id)
    // {
    //     $schedule = $this->doorToDoorServiceRepository->find($doorToDoorService_id);
        
    //     $car_capacity = $this->carRepository->get_capacity($schedule['car_id']);
    //     $qty = $this->doorToDoorOrderRepository->get_qty_confirmed($schedule['id']);
    //     $schedule['available'] = $car_capacity-$qty;

    //     return response()->json(new DoorToDoorServiceItem($schedule), 200);
    // }

    public function task_driver(Request $request)
    {
        $data = $this->doorToDoorServiceRepository->get_by_driver($request->user()->id);

        foreach ($data as $service) {
            $passenger = $this->doorToDoorOrderRepository->passenger($service->id);
            $service['passenger_count'] = $passenger->count();
        }

        $task = new ListTaskDriverCollection($data);

        return response()->json($task, 200);
    }

    public function passenger($doorToDoorService_id)
    {
        $data = new ListPassengerCollection($this->doorToDoorOrderRepository->passenger($doorToDoorService_id));

        return response()->json($data, 200);
    }

    public function passenger_orderBy_pickup($doorToDoorService_id)
    {
        $data = new ListPassengerCollection($this->doorToDoorOrderRepository->passenger_orderBy_pickup($doorToDoorService_id));

        return response()->json($data, 200);
    }

    public function passenger_orderBy_dropoff($doorToDoorService_id)
    {
        $data = new ListPassengerCollection($this->doorToDoorOrderRepository->passenger_orderBy_dropoff($doorToDoorService_id));

        return response()->json($data, 200);
    }
}
