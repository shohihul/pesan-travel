<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Requests\CarStoreRequest;
use App\Repositories\CarRepository;
use File;

class CarController extends Controller
{
    private $carRepository;

    public function __construct(CarRepository $carRepository)
    {
        $this->middleware('roles:admin');

        $this->carRepository = $carRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $per_page = 10;
        $car = $this->carRepository->getPaginate($per_page);

        return view('admin.car.index',
            compact(
                'car'
            ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.car.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarStoreRequest $request)
    {
        $photo = $request->file('photo');
        $fileName = 'car-' . time() . '.' . $photo->getClientOriginalExtension();

        $this->carRepository->store($request, $fileName);
        $this->carRepository->fileUpload($photo, $fileName);

        return redirect(route('admin.car.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        return view('admin.car.edit',
            compact(
                'car'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $this->carRepository->update($request, $car);

        return redirect(route('admin.car.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Car $car)
    {
        $file = public_path('assets/img/car/' . $car->photo);
        $this->carRepository->destroy($car);

        if(File::exists($file)){
            $this->carRepository->destroyFile($car);
        }

        return redirect(route('admin.car.index'));
    }
}
