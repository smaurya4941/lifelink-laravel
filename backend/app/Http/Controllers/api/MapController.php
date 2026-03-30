<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MapController as WebMapController;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function data(Request $request)
    {
        $controller = new WebMapController();
        return $controller->data($request);
    }

    public function markers(Request $request)
    {
        $controller = new WebMapController();
        return $controller->markers($request);
    }
}
