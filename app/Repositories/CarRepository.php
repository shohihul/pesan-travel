<?php

namespace App\Repositories;

use App\Models\Car;
use App\Http\Requests\CarStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class CarRepository
{
	protected $model;

	public function __construct(Car $model)
	{
        //Instance model User ke dalam property user
	    $this->model = $model;
    }

    public function get_car()
    {
        $car = Car::all();

        return $car;
    }
    
    //MEMBUAT FUNGSI UNTUK MENGAMBIL DATA YANG TELAH DI PAGINATE
    //DAN DIFUNGSI INI TELAH DIURUTKAN BERDASARKAN CREATED_AT
    //FUNGSI INI MEMINTA PARAMETER JUMLAH DATA YANG AKAN DITAMPILKAN
    public function getPaginate($per_page)
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate($per_page);
    }

    public function get_capacity($car_id)
    {
        return $this->model->find($car_id)->value('capacity');
    }

    //MEMBUAT FUNGSI UNTUK MENGAMBIL DATA BERDASARKAN ID
	public function find($id)
	{
		return $this->model->find($id);
	}

    //MEMBUAT FUNGSI UNTUK MENGAMBIL DATA BERDASRAKAN COLOMN YANG DITERIMA
	public function findBy($column, $data)
	{
		return $this->user->where($column, $data)->get();
    }
    
    public function store(CarStoreRequest $request, $fileName)
    {
        DB::beginTransaction();

        try {
            $this->model->create([
                'name' => $request->name,
                'capacity' => $request->capacity,
                'photo' => $fileName
            ]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function fileUpload($photo, $fileName)
    {
        $photo->move(public_path('assets/img/car'), $fileName);
    }

    public function destroy(Car $car)
    {
        DB::beginTransaction();

        try {
            $car->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function update(Request $request, Car $car)
    {
        DB::beginTransaction();

        try {
            $car->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function destroyFile(Car $car)
    {
        File::delete(public_path('assets/img/car/' . $car->photo));
    }
}