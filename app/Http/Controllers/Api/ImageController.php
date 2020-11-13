<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function getImage($fileName)
    {
        $path = public_path().'/assets/img/photo-profile/'.$fileName;
        return Response::download($path);
    }
}
