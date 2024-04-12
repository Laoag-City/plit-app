<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Business;

class StatisticsService
{
	public function getGeneralStatistics($method, ...$infos)
	{
		$now = Carbon::now();
		$now->hour = 0;
		$now->minute = 0;
		$now->second = 0;

		$businesses = Business::all();
		$stats_collection = collect([]);
		
		if(in_array('no_inspections', $infos) || empty($infos))
			$stats_collection->put('no_inspections', $businesses->where('inspection_count', 0)->$method());

		if(in_array('initial_inspections', $infos) || empty($infos))
			$stats_collection->put('initial_inspections', $businesses->where('inspection_count', 1)->$method());

		if(in_array('re_inspections', $infos) || empty($infos))
			$stats_collection->put('re_inspections', $businesses->where('inspection_count', 2)->$method());

		if(in_array('for_closures', $infos) || empty($infos))
			$stats_collection->put('for_closures', $businesses->where('inspection_count', 3)->$method());

		if(in_array('complied', $infos) || empty($infos))
			$stats_collection->put('complied', $businesses->where('inspection_count', 4)->$method());

		if(in_array('expired', $infos) || empty($infos))
			$stats_collection->put('expired', $businesses->where('inspection_count', 5)->$method());

		if(in_array('inspection_today', $infos) || empty($infos))
			$stats_collection->put('inspection_today', $businesses->where('inspection_date', '<=', $now)
								->whereIn('inspection_count', [1, 2])
								->$method());

		if(in_array('re_inspection_today', $infos) || empty($infos))
			$stats_collection->put('re_inspection_today', $businesses->where('re_inspection_date', '<=', $now)
								->whereIn('inspection_count', [1, 2])
								->$method());

		if(in_array('due_from_today', $infos) || empty($infos))
			$stats_collection->put('due_from_today', $businesses->where('due_date', '<=', $now)
								->whereIn('inspection_count', [1, 2])
								->$method());

		return $stats_collection;
	}
}

?>