<?php

namespace App\Services;

use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class YearService
{
	private $now;

	public function __construct()
	{
		$this->now = Carbon::now()->year;//dd($this->now);
	}

	public function checkYear()
	{
		$latest_year = Year::latest('year')->first();

		//if none is saved in the database yet, initialize the year now
		if($latest_year == null)
		{
			$year = new Year;
			$year->year = $this->now;
			$year->save();
		}
		
		//if there are years saved in the database, check if it is already a new year, then update businesses if it is true
		elseif($this->now > $latest_year->year)
		{
			$latest_year = $latest_year->year;

			while($this->now > $latest_year)
			{
				$latest_year++;
			}

			$year = new Year;
			$year->year = $latest_year;
			$year->save();

			//reset fields related to renewal
			DB::table('businesses')
				->update([
					'inspection_count' => 5,
					'inspection_date' => null,
					're_inspection_date' => null,
					'due_date' => null
			]);

			DB::table('business_requirements')
				->update([
					'requirement_params_value' => null,
					'complied' => false
			]);

			//remove non-mandatory requirements
			DB::table('requirements')
				->where('mandatory', '=', false)
				->delete();

			//reset remarks
			DB::table('remarks')->truncate();
		}
	}
}

?>