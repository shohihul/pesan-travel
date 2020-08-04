<?php

namespace App\Repositories;

use App\Models\DoorToDoorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DoorToDoorServiceRepository
{
	protected $model;

	public function __construct(DoorToDoorService $model)
	{
	    $this->model = $model;
    }

    public function find($id)
	{
		return $this->model->find($id);
    }

    public function get_by_origin_destination_id($origin_id, $destination_id)
    {
        return $this->model
            ->where('origin_id', $origin_id)
            ->where('destination_id', $destination_id)
            ->get();
    }
    
    public function get_route()
    {
        return $this->model
            ->where('status', 'scheduled')
            ->groupBy('origin_id', 'destination_id')
            ->select('origin_id', 'destination_id')
            -get();
    }
    
    public function get_scheduled()
    {
        return $this->model->where('status', 'scheduled')->get();
    }

    public function getRouteStatus()
    {
        return $this->model->getRouteStatus();
    }
    
    public function store($request)
    {
        DB::beginTransaction();

        try {
            $this->model->create($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function route_status_available(DoorToDoorService $service)
    {
        $service->route_status = 1;
        $service->save();
    }

    public function route_status_unavailable(DoorToDoorService $service)
    {
        $service->route_status = 0;
        $service->save();
    }

    public function search_route($distance_matrix, $total_passenger)
    {
        $visibility = [];

        $iteration = 5;
        $ant = $total_passenger;
        $beta = 2;
        $q0 = 0.9;
        $early_pheromone = 0.5;
        $local_evaporation_parameter = 0.1;
        $global_evaporation_parameter = 0.1;

        $pheromone = [];
        $starting_point = [];
        $unvisited_point = [];

        //Make visibility value or invers from distance matrix
        for ($i=0; $i < count($distance_matrix); $i++) { 

            $visibility[$i] = [];
            for ($j=0; $j < count($distance_matrix[$i]); $j++) {
                
                if ($i != $j) {
                    $visibility[$i][$j] = round(1/$distance_matrix[$i][$j], 2);
                } else {
                    $visibility[$i][$j] = 0;
                }
                
            }
        }

        // Inisiasi nilai pheromone
        for ($i=0; $i < $ant; $i++) { 

            $pheromone[$i] = [];
            for ($j=0; $j < $ant; $j++) { 

                $pheromone[$i][$j] = $early_pheromone;
            }
        }

        // Inisiasi posisi awal semut
        for ($j=0; $j < $ant; $j++) { 

            $unvisited_point[$j] = [];
            $unvisited_point[$j] = range(0, $ant-1);
            $starting_point[$j] = $j;

            unset($unvisited_point[$j][array_search($starting_point[$j],$unvisited_point[$j])]);

            
        }

        $route = [];
        $tour = [];
        //Membangun lintasan
        for ($z=0; $z < $iteration; $z++) { 

            $route[$z] = [];
            $current_unvisited_point = $unvisited_point;
            $current_point = $starting_point;
            for ($i=0; $i < $ant-1; $i++) { 

                $route[$z][$i] = [];
                for ($j=0; $j < $ant; $j++) { 

                    $q = rand(1, 10)/10;
                    $next_point;
                    
                    if ($q <= $q0) {

                        $temporary_max = 0;

                        // Mencari titik berikutnya
                        for ($k=0; $k < $ant; $k++) {

                            if (in_array($k, $current_unvisited_point[$j])) {
                                
                                $temporary = $pheromone[$current_point[$i]][$k] * ($visibility[$i][$k]^$beta);
                                if ($temporary > $temporary_max) {

                                    $temporary_max = $temporary;
                                    $next_point = $k;
                                }
                            }
                        }
                    } else {
                        
                        $temporary_total = 0;

                        for ($l=0; $l < $ant-1; $l++) { 
                            $temporary = $pheromone[$current_point[$i]][$l] * ($visibility[$i][$l]^$beta);
                            $temporary_total += $temporary;
                        }

                        $probability_max = 0;

                        // Mencari titik berikutnya
                        for ($k=0; $k < $ant; $k++) { 

                            if (in_array($k, $current_unvisited_point[$j])) {

                                $temporary = $pheromone[$current_point[$i]][$k] * ($visibility[$i][$k]^$beta);
                                $probability = $temporary/$temporary_total;

                                if ($probability > $probability_max) {

                                    $probability_max = $probability;
                                    $next_point = $k;

                                }
                            }
                        }
                    }
                    unset($current_unvisited_point[$j][array_search($next_point,$current_unvisited_point[$j])]);
                    $route[$z][$i][$j] = [$current_point[$j], $next_point];
                    
                    
                }

                // Local Pheromone Update
                for ($j=0; $j < $ant; $j++) { 

                    $r = $route[$z][$i][$j][0];
                    $s = $route[$z][$i][$j][1];

                    $pheromone[$r][$s] = (1-$local_evaporation_parameter) * $pheromone[$r][$s] + $local_evaporation_parameter * $early_pheromone;

                    $current_point[$j] = $s;
                    
                }
            }

            // Global Pheromone Update
            $tour[$z] = [];
            //Menghitung panjang rute
            for ($i=0; $i < $ant; $i++) { 
                
                $tour[$z][$i] = 0;
                for ($j=0; $j < $ant-1; $j++) {
                        
                    $r = $route[$z][$j][$i][0];
                    $s = $route[$z][$j][$i][1];

                    $tour[$z][$i] += $distance_matrix[$r][$s];
                }
            };
            $best_tour = min($tour[$z]);
            $best_route = array_search(min($tour[$z]), $tour[$z]);
            
            for ($i=0; $i < $ant; $i++) {

                if ($i == $best_route) {
                    $delta_t = round(1/10, 2);
                } else {
                    $delta_t = 0;
                }

                for ($j=0; $j < $ant-1; $j++) { 
                    $r = $route[$z][$j][$i][0];
                    $s = $route[$z][$j][$i][1];

                    $pheromone[$r][$s] = (1-$global_evaporation_parameter) * $pheromone[$r][$s] + $global_evaporation_parameter * $delta_t;
                }
            }
        }

        $best_i = 0;
        $best_j = 0;

        for ($i=0; $i < count($tour); $i++) { 
            for ($j=0; $j < count($tour[$i]); $j++) { 
                
                if ($tour[$i][$j] < $tour[$best_i][$best_j]) {
                    $best_i = $i;
                    $best_j = $j;
                }
            }
        }

        $global_best_tour = $tour[$best_i][$best_j];
        $global_best_route = [];

        for ($i=0; $i < $ant-1; $i++) { 

            if ($i == 0) {
                array_push($global_best_route, $starting_point[$best_j], $route[$best_i][0][$best_j][1]);
            } else {
                array_push($global_best_route, $route[$best_i][$i][$best_j][1]);
            }
        }

        $result = array(
            'total_distance' => $global_best_tour,
            'route' => $global_best_route
        );

        return $result;
    }
}