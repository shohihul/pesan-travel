<?php

namespace App\Repositories;

use App\Models\Regencie;
use App\Models\Province;
use App\Http\Requests\CarStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AreaRepository
{
    protected $regencie;
    protected $province;

	public function __construct(Regencie $regencie, Province $province)
	{
        //Instance model User ke dalam property user
        $this->regencie = $regencie;
        $this->province = $province;
    }

    public function get_province()
    {
        $province = Province::all();

        return $province;
    }

    public function get_regencie_by_province(Request $request)
    {
        
        if (!$request->province_id) {
            $html = '<option value="">Null</option>';
        } else {
            $html = '';
            $regencies = Regencie::where('province_id', $request->province_id)->get();
            foreach ($regencies as $regency) {
                $html .= '<option value="'.$regency->id.'">'.$regency->name.'</option>';
            }
        }
        return response()->json(['html' => $html]);
    }
}