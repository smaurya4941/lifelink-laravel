<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AnalyticsController as WebAnalyticsController;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $web = new WebAnalyticsController();
        return $web->data($request);
    }

    public function predictive(Request $request)
    {
        $web = new WebAnalyticsController();
        return $web->predictive($request);
    }
}
