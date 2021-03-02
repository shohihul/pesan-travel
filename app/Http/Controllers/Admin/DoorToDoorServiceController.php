<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\DoorToDoorServiceRepository;
use App\Repositories\DoorToDoorOrderRepository;
use App\Repositories\AreaRepository;
use App\Repositories\CarRepository;
use App\Repositories\UserRepository;
use App\Repositories\InvoiceRepository;

use App\Http\Requests\DoorToDoorServiceStoreRequest;

use App\Models\Regencie;
use App\Models\DoorToDoorService;

class DoorToDoorServiceController extends Controller
{
    private $doorToDoorServiceRepository;
    private $doorToDoorOrderRepository;
    private $areaRepository;
    private $carRepository;
    private $invoiceRepository;

    public function __construct (
        DoorToDoorServiceRepository $doorToDoorServiceRepository,
        DoorToDoorOrderRepository $doorToDoorOrderRepository,
        AreaRepository $areaRepository,
        CarRepository $carRepository,
        UserRepository $userRepository,
        InvoiceRepository $invoiceRepository
        )
    {
        $this->middleware('roles:admin');

        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;
        $this->areaRepository = $areaRepository;
        $this->carRepository = $carRepository;
        $this->userRepository = $userRepository;
        $this->invoiceRepository = $invoiceRepository;

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
        $data = $this->doorToDoorServiceRepository->find($doorToDoorService_id);
        $passenger = $this->doorToDoorOrderRepository->passenger($doorToDoorService_id);
        $bookers = $this->doorToDoorOrderRepository->bookers($doorToDoorService_id);

        $invoiceStatus = $this->invoiceRepository->getInvoiceStatus();
        $locationStatus = $this->doorToDoorOrderRepository->getLocationStatus();
        $passengerStatus = $this->doorToDoorOrderRepository->getStatus();
        $serviceStatus = $this->doorToDoorServiceRepository->getStatus();
        
        // return $passenger;
        return view('admin.doorToDoor_service.show',
            compact(
                'data',
                'passenger',
                'bookers',
                'invoiceStatus',
                'locationStatus',
                'passengerStatus',
                'serviceStatus'
            )
        );
    }

    public function route(DoorToDoorService $doorToDoorService)
    {
        $doorToDoorService_id = $doorToDoorService->id;

        if ($doorToDoorService['route_ready'] == false) {
            return redirect(route('admin.doorToDoor_service.show', $doorToDoorService_id));
        }

        $passenger = $this->doorToDoorOrderRepository->passenger($doorToDoorService_id);
        $passenger_orderBy_pickup =  $this->doorToDoorOrderRepository->passenger_orderBy_pickup($doorToDoorService_id);
        $passenger_orderBy_dropoff =  $this->doorToDoorOrderRepository->passenger_orderBy_dropoff($doorToDoorService_id);

        $pickup_route = [];
        for ($i=0; $i < count($passenger_orderBy_pickup)-1; $i++) { 
            $pickup_route[$i][0] = $passenger_orderBy_pickup[$i]['pickup_point'];
            $pickup_route[$i][1] = $passenger_orderBy_pickup[$i+1]['pickup_point'];
        }

        $dropoff_route = [];
        for ($i=0; $i < count($passenger_orderBy_dropoff)-1; $i++) { 
            $dropoff_route[$i][0] = $passenger_orderBy_dropoff[$i]['dropoff_point'];
            $dropoff_route[$i][1] = $passenger_orderBy_dropoff[$i+1]['dropoff_point'];
        }

        return view('admin.doorToDoor_service.route',
            compact(
                'pickup_route',
                'dropoff_route',
                'doorToDoorService',
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

    public function ajax_update(Request $request, DoorToDoorService $doorToDoorService)
    {
        error_log('yyy');
        $this->doorToDoorServiceRepository->update($request, $doorToDoorService);
        $response = "Data berhasil diperbaharui";

        return response()->json($response);
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

    public function permutation_route(DoorToDoorService $doorToDoorService)
    {
        $doorToDoorService_id = $doorToDoorService->id;
        $passenger = $this->doorToDoorOrderRepository->passenger($doorToDoorService_id);
        $total_passenger = count($passenger);

        return $passenger;

        $combination = [
            [0,1],
            [0,2],
            [0,3],
            [0,4],
            [1,2],
            [1,3],
            [1,4],
            [2,3],
            [2,4],
            [3,4],
            [1,0],
            [2,0],
            [3,0],
            [4,0],
            [2,1],
            [3,1],
            [4,1],
            [3,2],
            [4,2],
            [4,3],
        ];
        // return array_search([1,0], $combination);

        $distance_combination = [];

        for ($i=0; $i < count($combination); $i++) { 
            $start = $passenger[$combination[$i][0]]['pickup_point'];
            $end = $passenger[$combination[$i][1]]['pickup_point'];

            $dataJson = file_get_contents(
                "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
                .$start
                ."&destinations=".$end
                ."&key=".env('GOOGLE_MAP_KEY')
            );

            $data = json_decode($dataJson,true);
            $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];

            $distance_combination[$i] = round($distance_value/1000, 1);
        }

        $permutation = [
            [0,1,2,3,4],
            [1,0,2,3,4],
            [2,0,1,3,4],
            [0,2,1,3,4],
            [1,2,0,3,4],
            [2,1,0,3,4],
            [2,1,3,0,4],
            [1,2,3,0,4],
            [3,2,1,0,4],
            [2,3,1,0,4],
            [1,3,2,0,4],
            [3,1,2,0,4],
            [3,0,2,1,4],
            [0,3,2,1,4],
            [2,3,0,1,4],
            [3,2,0,1,4],
            [0,2,3,1,4],
            [2,0,3,1,4],
            [1,0,3,2,4],
            [0,1,3,2,4],
            [3,1,0,2,4],
            [1,3,0,2,4],
            [0,3,1,2,4],
            [3,0,1,2,4],
            [4,0,1,2,3],
            [0,4,1,2,3],
            [1,4,0,2,3],
            [4,1,0,2,3],
            [0,1,4,2,3],
            [1,0,4,2,3],
            [1,0,2,4,3],
            [0,1,2,4,3],
            [2,1,0,4,3],
            [1,2,0,4,3],
            [0,2,1,4,3],
            [2,0,1,4,3],
            [2,4,1,0,3],
            [4,2,1,0,3],
            [1,2,4,0,3],
            [2,1,4,0,3],
            [4,1,2,0,3],
            [1,4,2,0,3],
            [0,4,2,1,3],
            [4,0,2,1,3],
            [2,0,4,1,3],
            [0,2,4,1,3],
            [4,2,0,1,3],
            [2,4,0,1,3],
            [3,4,0,1,2],
            [4,3,0,1,2],
            [0,3,4,1,2],
            [3,0,4,1,2],
            [4,0,3,1,2],
            [0,4,3,1,2],
            [0,4,1,3,2],
            [4,0,1,3,2],
            [1,0,4,3,2],
            [0,1,4,3,2],
            [4,1,0,3,2],
            [1,4,0,3,2],
            [1,3,0,4,2],
            [3,1,0,4,2],
            [0,1,3,4,2],
            [1,0,3,4,2],
            [3,0,1,4,2],
            [0,3,1,4,2],
            [4,3,1,0,2],
            [3,4,1,0,2],
            [1,4,3,0,2],
            [4,1,3,0,2],
            [3,1,4,0,2],
            [1,3,4,0,2],
            [2,3,4,0,1],
            [3,2,4,0,1],
            [4,2,3,0,1],
            [2,4,3,0,1],
            [3,4,2,0,1],
            [4,3,2,0,1],
            [4,3,0,2,1],
            [3,4,0,2,1],
            [0,4,3,2,1],
            [4,0,3,2,1],
            [3,0,4,2,1],
            [0,3,4,2,1],
            [0,2,4,3,1],
            [2,0,4,3,1],
            [4,0,2,3,1],
            [0,4,2,3,1],
            [2,4,0,3,1],
            [4,2,0,3,1], ///////////
            [3,2,0,4,1],
            [2,3,0,4,1],
            [0,3,2,4,1],
            [3,0,2,4,1],
            [2,0,3,4,1],
            [0,2,3,4,1],
            [1,2,3,4,0],
            [2,1,3,4,0],
            [3,1,2,4,0],
            [1,3,2,4,0],
            [2,3,1,4,0],
            [3,2,1,4,0],
            [3,2,4,1,0],
            [2,3,4,1,0],
            [4,3,2,1,0],
            [3,4,2,1,0],
            [2,4,3,1,0],
            [4,2,3,1,0],
            [4,1,3,2,0],
            [1,4,3,2,0],
            [3,4,1,2,0],
            [4,3,1,2,0],
            [1,3,4,2,0],
            [3,1,4,2,0],
            [2,1,4,3,0],
            [1,2,4,3,0],
            [4,2,1,3,0],
            [2,4,1,3,0],
            [1,4,2,3,0],
            [4,1,2,3,0],
        ];

        return $distance_combination[array_search([3,1], $combination)];

        $distance_permutation = [];

        for ($i=0; $i < count($permutation); $i++) { 

            $distance = [];
            $count_distance = 0;
            for ($j=0; $j < count($permutation[$i]); $j++) {

                if ($j != count($permutation[$i])-1) {
                    $start = $permutation[$i][$j];
                    $end =  $permutation[$i][$j+1];

                    // $start = $passenger[$combination[$a][0]]['pickup_point'];
                    // $end = $passenger[$combination[$b][1]]['pickup_point'];

                    // $dataJson = file_get_contents(
                    //     "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
                    //     .$start
                    //     ."&destinations=".$end
                    //     ."&key=".env('GOOGLE_MAP_KEY')
                    // );
                    // $data = json_decode($dataJson,true);
                    // $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];

                    // $distance[$i] = round($distance_value/1000, 1);
                    

                    $key = array_search([$start, $end], $combination);
                    $count_distance += $distance_combination[$key];
                }
            }
            $distance_permutation[$i] = $count_distance;
        }

        return $distance_permutation;
    }

    public function search_route(DoorToDoorService $doorToDoorService)
    {
        $doorToDoorService_id = $doorToDoorService->id;

        if ($doorToDoorService['route_ready'] == true) {
            return redirect(route('admin.doorToDoor_service.route', $doorToDoorService_id));
        }

        $passenger = $this->doorToDoorOrderRepository->passenger($doorToDoorService_id);
        $total_passenger = count($passenger);

        // Make distance matrix
        $pickup_distance_matrix = [];
        for ($i=0; $i < $total_passenger ; $i++) { 

            $pickup_distance_matrix[$i] = [];
            for ($j=0; $j < $total_passenger ; $j++) { 

                if ($i != $j) {
                    $pickup_point_start = $passenger[$i]['pickup_point'];
                    $pickup_point_end = $passenger[$j]['pickup_point'];

                    $dataJson = file_get_contents(
                        "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
                        .$pickup_point_start
                        ."&destinations=".$pickup_point_end
                        ."&key=".env('GOOGLE_MAP_KEY')
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
                    $dropoff_point_start = $passenger[$i]['dropoff_point'];
                    $dropoff_point_end = $passenger[$j]['dropoff_point'];

                    $dataJson = file_get_contents(
                        "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
                        .$dropoff_point_start
                        ."&destinations=".$dropoff_point_end
                        ."&key=".env('GOOGLE_MAP_KEY')
                    );

                    $data = json_decode($dataJson,true);
                    $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];

                    $dropoff_distance_matrix[$i][$j] = round($distance_value/1000, 1);
                } else {
                    $dropoff_distance_matrix[$i][$j] = 0;
                }
            }   
        }

        $pickup_result = $this->doorToDoorServiceRepository->ant_colony(
            $pickup_distance_matrix, $total_passenger);
        $dropoff_result = $this->doorToDoorServiceRepository->ant_colony(
            $dropoff_distance_matrix, $total_passenger);        

        for ($i=0; $i < count($passenger); $i++) {
            
            $passenger_updated = $passenger[$i];
            $pickup = array_search($i, $pickup_result['route'])+1;
            $dropoff = array_search($i, $dropoff_result['route'])+1;
            $this->doorToDoorOrderRepository->update_sequence($passenger_updated, $pickup, $dropoff);
        }

        $this->doorToDoorServiceRepository->route_ready_true($doorToDoorService);
        return redirect(route('admin.doorToDoor_service.route', $doorToDoorService_id));
    }


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
}

// public function search_route(DoorToDoorService $doorToDoorService)
// {
//     $doorToDoorService_id = $doorToDoorService->id;
//     if ($doorToDoorService['route_ready'] == true) {
//         return redirect(route('admin.doorToDoor_service.route', $doorToDoorService_id));
//     }
//     $passenger = $this->doorToDoorOrderRepository->passenger($doorToDoorService_id);
//     $total_passenger = count($passenger);
//     $pickup_distance_matrix = [];
//     for ($i=0; $i < $total_passenger ; $i++) { 
//         $pickup_distance_matrix[$i] = [];
//         for ($j=0; $j < $total_passenger ; $j++) { 
//             if ($i != $j) {
//                 $pickup_point_start = $passenger[$i]['pickup_point'];
//                 $pickup_point_end = $passenger[$j]['pickup_point'];
//                 $dataJson = file_get_contents(
//                     "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
//                     .$pickup_point_start
//                     ."&destinations=".$pickup_point_end
//                     ."&key=".env('GOOGLE_MAP_KEY')
//                 );
//                 $data = json_decode($dataJson,true);
//                 $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];
//                 $pickup_distance_matrix[$i][$j] = round($distance_value/1000, 1);
//             } else {
//                 $pickup_distance_matrix[$i][$j] = 0;
//             }
//         }
//     }
//     $dropoff_distance_matrix = [];
//     for ($i=0; $i < $total_passenger ; $i++) { 
//         $dropoff_distance_matrix[$i] = [];
//         for ($j=0; $j < $total_passenger ; $j++) { 
//             if ($i != $j) {
//                 $dropoff_point_start = $passenger[$i]['dropoff_point'];
//                 $dropoff_point_end = $passenger[$j]['dropoff_point'];
//                 $dataJson = file_get_contents(
//                     "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins="
//                     .$dropoff_point_start
//                     ."&destinations=".$dropoff_point_end
//                     ."&key=".env('GOOGLE_MAP_KEY')
//                 );
//                 $data = json_decode($dataJson,true);
//                 $distance_value = $data['rows'][0]['elements'][0]['distance']['value'];
//                 $dropoff_distance_matrix[$i][$j] = round($distance_value/1000, 1);
//             } else {
//                 $dropoff_distance_matrix[$i][$j] = 0;
//             }
//         }   
//     }
//     $pickup_result = $this->doorToDoorServiceRepository
//                         ->ant_colony($pickup_distance_matrix, $total_passenger);
//     $dropoff_result = $this->doorToDoorServiceRepository
//                         ->ant_colony($dropoff_distance_matrix, $total_passenger);
//     for ($i=0; $i < count($passenger); $i++) {
//         $passenger_updated = $passenger[$i];
//         $pickup = array_search($i, $pickup_result['route'])+1;
//         $dropoff = array_search($i, $dropoff_result['route'])+1;
//         $this->doorToDoorOrderRepository->update_sequence($passenger_updated, $pickup, $dropoff);
//     }
//     $this->doorToDoorServiceRepository->route_ready_true($doorToDoorService);
//     return redirect(route('admin.doorToDoor_service.route', $doorToDoorService_id));
// }