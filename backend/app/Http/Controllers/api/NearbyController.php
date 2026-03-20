<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NearbyController as WebNearbyController;
use Illuminate\Http\Request;

class NearbyController extends Controller
{
    public function donors(Request $request)
    {
        $controller = new WebNearbyController();
        return $controller->donors($request);
    }

    public function requests(Request $request)
    {
        $controller = new WebNearbyController();
        return $controller->requests($request);
    }
}
