<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\DoorToDoorServiceRepository;

use App\Http\Requests\DoorToDoorOrderStoreRequest;
use App\Repositories\DoorToDoorOrderRepository;

class DoorToDoorOrderController extends Controller
{
    private $userRepository;
    private $doorToDoorServiceRepository;
    private $doorToDoorOrderRepository;

    public function __construct (UserRepository $userRepository, DoorToDoorServiceRepository $doorToDoorServiceRepository, DoorToDoorOrderRepository $doorToDoorOrderRepository)
    {
        $this->middleware('roles:admin');

        $this->userRepository = $userRepository;
        $this->doorToDoorServiceRepository = $doorToDoorServiceRepository;
        $this->doorToDoorOrderRepository = $doorToDoorOrderRepository;


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $customers = $this->userRepository->get_customer();
        $service = $this->doorToDoorServiceRepository->find($id);

        return view('admin.doorToDoor_order.create',
            compact(
                'customers',
                'service'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoorToDoorOrderStoreRequest $request)
    {
        $service = $request->get('door_to_door_service_id');
        $this->doorToDoorOrderRepository->store($request);
        $this->doorToDoorServiceRepository->route_status_unavailable($service);
        return $service;

        return redirect(route('admin.doorToDoor_service.show', $service));
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
}
