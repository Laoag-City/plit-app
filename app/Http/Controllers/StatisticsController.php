<?php

namespace App\Http\Controllers;

use App\Http\Requests\StatisticTypeRequest;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class StatisticsController extends Controller
{
    public function showSpecificStats(StatisticTypeRequest $request): View
    {
        $stat_type = $request->view;
        $results = (new StatisticsService)->getGeneralStatistics('collect', $stat_type);

        return view('business.business-stats', [
            'category' => Str::title(Str::of($stat_type)->replace('_', ' ')),
            'businesses' => $results[ $stat_type]
        ]);
    }
}
