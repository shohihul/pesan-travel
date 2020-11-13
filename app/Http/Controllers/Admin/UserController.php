<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\UserStoreRequest;
use App\Repositories\UserRepository;
use File;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('roles:admin');

        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function driverIndex()
    {
        $per_page = 10;
        $driver = $this->userRepository->getPaginate_driver($per_page);

        return view('admin.user.driver',
            compact(
                'driver'
            )
        );
    }

    public function customerIndex()
    {
        $per_page = 10;
        $customer = $this->userRepository->getPaginate_customer($per_page);

        return view('admin.user.customer',
            compact(
                'customer'
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
        $roles =  $this->userRepository->get_role();

        return view('admin.user.create',
            compact(
                'roles'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        if (!empty($request->file('photo'))) {
            $photo = $request->file('photo');
            $fileName = 'photoProfile-' . time() . '.' . $photo->getClientOriginalExtension();
            $this->userRepository->fileUpload($photo, $fileName);
        } else {
            $fileName = null;
        }
        
        $this->userRepository->store($request, $fileName);

        return redirect(route('admin.dashboard'));
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
    public function edit(User $user)
    {
        return view('admin.user.edit',
            compact(
                'user'
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
    public function update(Request $request, User $user)
    {
        $fileName;
        if ($request->photo != null) {
            $delete = public_path('assets/img/photo-profile/' . $user->photo);
            if(File::exists($delete)){
                $this->userRepository->destroyFile($user);
            }

            $photo = $request->file('photo');
            $fileName = 'photoProfile-' . time() . '.' . $photo->getClientOriginalExtension();
            $this->userRepository->fileUpload($photo, $fileName);
        } else {
            $fileName = $user->photo;
        }

        $this->userRepository->update($request, $user, $fileName);

        if ($user->role_id == 3) {
            return redirect(route('admin.customer.index'));
        } else {
            return redirect(route('admin.driver.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(User $user)
    {
        $file = public_path('assets/img/photo-profile/' . $user->photo);
        $this->userRepository->destroy($user);

        if(File::exists($file)){
            $this->userRepository->destroyFile($user);
        }

        if ($user->role_id == 3) {
            return redirect(route('admin.customer.index'));
        } else {
            return redirect(route('admin.driver.index'));
        }
    }
}
