<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AreaRepository;

class AreaController extends Controller
{
    private $areaRepository;

    public function __construct(AreaRepository $areaRepository)
    {
        $this->areaRepository = $areaRepository;
    }

    public function getRegencieByProvince(Request $request)
    {
        $regencie = $this->areaRepository->get_regencie_by_province($request);

        return $regencie;
    }
}
