<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingAccount;
use App\Repositories\SavingAccountRepository;
use App\Http\Requests\SavingAccountStoreRequest;

class SavingAccountsController extends Controller
{
    private $savingAccountRepository;

    public function __construct(SavingAccountRepository $savingAccountRepository)
    {
        $this->middleware('roles:admin');

        $this->savingAccountRepository = $savingAccountRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $savingAccount = $this->savingAccountRepository->get_all();

        return view('admin.savingAccount.index',
            compact(
                'savingAccount'
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
        return view('admin.savingAccount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logo = $request->file('logo');
        $fileName = 'bank-' . $request->bank_account . '.' . $logo->getClientOriginalExtension();

        $this->savingAccountRepository->store($request, $fileName);
        $this->savingAccountRepository->fileUpload($logo, $fileName);

        return redirect(route('admin.saving_account.index'));
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
        $savingAccount = $this->savingAccountRepository->find($id);
        return view('admin.savingAccount.edit',
            compact(
                'savingAccount'
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
    public function update(Request $request, SavingAccount $savingAccount)
    {
        $this->savingAccountRepository->update($request, $savingAccount);

        return redirect(route('admin.saving_account.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->savingAccountRepository->destroy($id);

        return redirect(route('admin.saving_account.index'));
    }
}
