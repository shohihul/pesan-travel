<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\SavingAccountRepository;

class SavingAccountsController extends Controller
{
    private $savingAccountRepository;

    public function __construct(SavingAccountRepository $savingAccountRepository)
    {
        $this->savingAccountRepository = $savingAccountRepository;
    }

    public function get_bank()
    {
        $savingAccount = $this->savingAccountRepository->get_bank();

        return response()->json($savingAccount, 200);
    }


}
