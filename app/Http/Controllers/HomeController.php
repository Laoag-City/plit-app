<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Carbon\Carbon;
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

		$now = Carbon::now();
		$now->hour = 0;
		$now->minute = 0;
		$now->second = 0;

		$businesses = Business::all();
		
		$no_inspections = $businesses->where('inspection_count', 0)->count();
		$initial_inspections = $businesses->where('inspection_count', 1)->count();
		$re_inspections = $businesses->where('inspection_count', 2)->count();
		$for_closures = $businesses->where('inspection_count', 3)->count();
		$complied = $businesses->where('inspection_count', 4)->count();
		$expired = $businesses->where('inspection_count', 5)->count();

		$inspection_today = $businesses->where('inspection_date', $now)
							->whereIn('inspection_count', [1, 2])
							->count();
		
		$re_inspection_today = $businesses->where('re_inspection_date', $now)
							->whereIn('inspection_count', [1, 2])
							->count();
		
		$due_from_today = $businesses->where('due_date', '<=', $now)
							->whereIn('inspection_count', [1, 2])
							->count();
		

		return view('welcome', [
			'greetings' => $greetings,
			'no_inspections' => $no_inspections,
			'initial_inspections' => $initial_inspections,
			're_inspections' => $re_inspections,
			'for_closures' => $for_closures,
			'complied' => $complied,
			'expired' => $expired,
			'inspection_today' => $inspection_today,
			're_inspection_today' => $re_inspection_today,
			'due_from_today' => $due_from_today,
		]);
	}
}
