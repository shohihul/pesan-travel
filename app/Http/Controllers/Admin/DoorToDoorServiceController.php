<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\DoorToDoorServiceRepository;
use App\Repositories\DoorToDoorOrderRepository;
use App\Repositories\AreaRepository;
use App\Repositories\CarRepository;
use App\Repositories\UserRepository;

use App\Http\Requests\DoorToDoorServiceStoreRequest;

use App\Models\Regencie;

class DoorToDoorServiceController extends Controller
{
    private $doorToDoorServiceRepository;
    private $doorToDoorOrderRepository;
    private $areaRepository;
    private $carRepository;

    public function __construct (
        DoorToDoorServiceRepository $doorToDoorServiceRepository,
        DoorToDoorOrderRepository $doorToDoorOrderRepository,
        AreaRepository $areaRepository,
        CarRepository $carRepository,
        UserRepository $userRepository)
    {
        $this->middleware('roles:admin');

        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;
        $this->areaRepository = $areaRepository;
        $this->carRepository = $carRepository;
        $this->userRepository = $userRepository;


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scheduled_index()
    {
        $scheduled = $this->doorToDoorServiceRepository->get_scheduled();

        return view('admin.doorToDoor_service.scheduled_index',
            compact(
                'scheduled'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = $this->areaRepository->get_province();
        $cars = $this->carRepository->get_car();
        $drivers = $this->userRepository->get_driver();

        return view('admin.doorToDoor_service.create',
            compact(
                'province',
                'cars',
                'drivers'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoorToDoorServiceStoreRequest $request)
    {
        $this->doorToDoorServiceRepository->store($request);

        return redirect(route('admin.dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($doorToDoorService_id)
    {
        $routeStatus = $this->doorToDoorServiceRepository->getRouteStatus();
        $data = $this->doorToDoorServiceRepository->find($doorToDoorService_id);
        $passenger = $this->doorToDoorOrderRepository->get_all();
        // return $passenger;
        return view('admin.doorToDoor_service.show',
            compact(
                'data',
                'passenger',
                'routeStatus'
            )
        );
    }

    public function route($doorToDoorService_id)
    {
        $service = $this->doorToDoorServiceRepository->find($doorToDoorService_id);

        if ($service['route_status'] == 0) {
            return redirect(route('admin.doorToDoor_service.show', $doorToDoorService_id));
        }

        $passenger = $this->doorToDoorOrderRepository->find_door_to_door_service_id($doorToDoorService_id);
        $passenger_orderBy_pickup =  $this->doorToDoorOrderRepository->passenger_orderBy_pickup($doorToDoorService_id);
        $passenger_orderBy_dropoff =  $this->doorToDoorOrderRepository->passenger_orderBy_dropoff($doorToDoorService_id);

        $pickup_route = [];
        for ($i=0; $i < count($passenger_orderBy_pickup)-1; $i++) { 
            $pickup_route[$i][0] = $passenger_orderBy_pickup[$i]['pick_up_point'];
            $pickup_route[$i][1] = $passenger_orderBy_pickup[$i+1]['pick_up_point'];
        }

        $dropoff_route = [];
        for ($i=0; $i < count($passenger_orderBy_dropoff)-1; $i++) { 
            $dropoff_route[$i][0] = $passenger_orderBy_dropoff[$i]['drop_off_point'];
            $dropoff_route[$i][1] = $passenger_orderBy_dropoff[$i+1]['drop_off_point'];
        }

        return view('admin.doorToDoor_service.route',
            compact(
                'pickup_route',
                'dropoff_route',
                'service',
                'passenger'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search_route($doorToDoorService_id)
    {
        $service = $this->doorToDoorServiceRepository->find($doorToDoorService_id);

        if ($service['route_status'] == 1) {
            return redirect(route('admin.doorToDoor_service.route', $doorToDoorService_id));
        }

        $passenger = $this->doorToDoorOrderRepository->find_door_to_door_service_id($doorToDoorService_id);
        $total_passenger = count($passenger);

        // Make distance matrix
        $pickup_distance_matrix = [];
        for ($i=0; $i < $total_passenger ; $i++) { 

            $pickup_distance_matrix[$i] = [];
            for ($j=0; $j < $total_passenger ; $j++) { 

                if ($i != $j) {
                    $pickup_point_start = $passenger[$i]['pick_up_point'];
                    $pickup_point_end = $passenger[$j]['pick_up_point'];

                    $dataJson = file_get_contents(
                        "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$pickup_point_start."&destinations=".$pickup_point_end."&key=".env('GOOGLE_MAP_KEY')
                    );

                    $data = json_decode($dataJson,true);
                    $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];

                    $pickup_distance_matrix[$i][$j] = round($distance_value/1000, 1);
                } else {
                    $pickup_distance_matrix[$i][$j] = 0;
                }
            }
        }
        
        $dropoff_distance_matrix = [];
        for ($i=0; $i < $total_passenger ; $i++) { 

            $dropoff_distance_matrix[$i] = [];
            for ($j=0; $j < $total_passenger ; $j++) { 

                if ($i != $j) {
                    $dropoff_point_start = $passenger[$i]['drop_off_point'];
                    $dropoff_point_end = $passenger[$j]['drop_off_point'];

                    $dataJson = file_get_contents(
                        "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$dropoff_point_start."&destinations=".$dropoff_point_end."&key=".env('GOOGLE_MAP_KEY')
                    );

                    $data = json_decode($dataJson,true);
                    $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];

                    $dropoff_distance_matrix[$i][$j] = round($distance_value/1000, 1);
                } else {
                    $dropoff_distance_matrix[$i][$j] = 0;
                }
            }   
        }

        $pickup_result = $this->doorToDoorServiceRepository->search_route($pickup_distance_matrix, $total_passenger);
        $dropoff_result = $this->doorToDoorServiceRepository->search_route($dropoff_distance_matrix, $total_passenger);
        
        // $route = [];
        // foreach ($pickup_route['route'] as $point) {
        //     array_push($route, $passenger[$point]['pick_up_point']);
        // }
        
        // $pickup_route = [];
        // for ($i=0; $i < count($pickup_result['route'])-1; $i++) { 
        //     $pickup_route[$i][0] = $passenger[$pickup_result['route'][$i]]['pick_up_point'];
        //     $pickup_route[$i][1] = $passenger[$pickup_result['route'][$i+1]]['pick_up_point'];
        // }

        // $dropoff_route = [];
        // for ($i=0; $i < count($dropoff_result['route'])-1; $i++) { 
        //     $dropoff_route[$i][0] = $passenger[$dropoff_result['route'][$i]]['drop_off_point'];
        //     $dropoff_route[$i][1] = $passenger[$dropoff_result['route'][$i+1]]['drop_off_point'];
        // }

        for ($i=0; $i < count($passenger); $i++) {
            
            $passenger_updated = $passenger[$i];
            $pickup = array_search($i, $pickup_result['route'])+1;
            $dropoff = array_search($i, $dropoff_result['route'])+1;
            $this->doorToDoorOrderRepository->update_sequence($passenger_updated, $pickup, $dropoff);
        }

        $this->doorToDoorServiceRepository->route_status_available($service);

        return redirect(route('admin.doorToDoor_service.route', $doorToDoorService_id));
    }
}
