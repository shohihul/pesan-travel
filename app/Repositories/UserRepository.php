<?php

namespace App\Repositories;

use App\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\UserStoreRequest;
use File;

class UserRepository
{
	protected $model;

	public function __construct(User $model)
	{
        $this->model = $model;
    }

    public function get_role()
    {
        $role = Role::all();
        return $role;
    }

    public function get_driver()
    {
        $driver = $this->model->where('role_id', 2)->get();

        return $driver;
    }

    public function get_customer()
    {
        return $this->model->where('role_id', 3)->get();
    }
    
    public function getPaginate_driver($per_page)
    {
        return $this->model->orderBy('created_at', 'DESC')
            ->where('role_id', 2)
            ->paginate($per_page);
    }

    public function getPaginate_customer($per_page)
    {
        return $this->model->orderBy('created_at', 'DESC')
            ->where('role_id', 3)
            ->paginate($per_page);
    }

    public function store(UserStoreRequest $request, $fileName)
    {
        DB::beginTransaction();

        try {
            $this->model->create([
                'name' => $request->name,
                'email' => $request->email,
                'role_id' => $request->role_id,
                'password' => $request->password,
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
        $photo->move(public_path('assets/img/photo-profile'), $fileName);
    }

    public function destroy(User $user)
    {
        DB::beginTransaction();

        try {
            $user->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }

    public function destroyFile(User $user)
    {
        File::delete(public_path('assets/img/photo-profile/' . $user->photo));
    }
}