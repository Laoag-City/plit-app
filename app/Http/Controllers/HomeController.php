<?php

namespace App\Http\Controllers;

use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
	public function __invoke(Request $request) : View
	{
		$hour = now()->hour;

		if($hour < 12)
			$greetings = 'Good morning';
		elseif($hour < 18)
			$greetings = 'Good afternoon';
		else
			$greetings = 'Good evening';

		return view('welcome', [
			'greetings' => $greetings,
			'stats' => (new StatisticsService)->getGeneralStatistics('count')
		]);
	}
}
