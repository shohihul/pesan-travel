<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role_id;

        if ($role == 1) {
            return redirect(route('admin.dashboard'));
        } elseif ($role == 2){
            return redirect(route('driver.home'));
        } elseif ($role == 3){
            return redirect(route('customer.home'));
        }
    }
}
