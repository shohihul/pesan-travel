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

    public function find($id)
	{
		return $this->model->find($id);
    }

    public function get_all()
    {
        return $this->model->get();
    }

    public function get_bank(Type $var = null)
    {
        return $this->model->select('id', 'bank_account', 'logo')->get();
    }

    public function store(Request $request, $fileName)
    {
        DB::beginTransaction();

        try {
            $this->model->create([
                'bank_account' => $request->bank_account,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
                'logo' => $fileName,
            ]);
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

    public function fileUpload($photo, $fileName)
    {
        $photo->move(public_path('assets/img/bank'), $fileName);
    }

    public function update(Request $request, SavingAccount $savingAccount)
    {
        DB::beginTransaction();

        try {
            $savingAccount->update($request->all());
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e);
        }
    }
}