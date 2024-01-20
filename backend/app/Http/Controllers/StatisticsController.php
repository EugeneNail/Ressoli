<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Application;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\Support\CurrentMonthDataNode;
use App\Models\Support\ApplicationDataNode;
use App\Models\User;
use App\Services\Statistics;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class StatisticsController extends Controller {

    public function __invoke(Request $request, Statistics $statistics) {
        $statistics = [
            "currentMonth" => $statistics->collectCurrentMonth($request->user()),
            "monthly" => $statistics->collectMonthly($request->user())
        ];

        return response()->json($statistics);
    }
}
