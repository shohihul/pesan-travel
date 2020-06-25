<?php

namespace App\Repositories;

use App\Models\SavingAccount;
use App\Http\Requests\SavingAccountStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavingAccountRepository
{
    protected $model;

	public function __construct(SavingAccount $model)
	{
	    $this->model = $model;
    }

    public function get_all()
    {
        return $this->model->get();
    }

    public function store(Request $request)
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

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->model->where('id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }
}