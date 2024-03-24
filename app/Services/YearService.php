<?php

namespace App\Services;

use App\Models\Year;
use Carbon\Carbon;

class YearService
{
	private $now;

	public function __construct()
	{
		$this->now = Carbon::now()->year;
	}

	public function checkYear()
	{
		//check if the year now is already recorded
		if(Year::where('year', $this->now)->count() == 0)
		{
			$year = new Year;
			$year->year = $this->now;
			$year->save();
		}

		else
			$year = Year::where('year', $this->now)->first();
	}

	public function isNewYear()
	{
		$latest_year = Year::latest('year')->first()->year;

		if($this->now > $latest_year)
		{

		}
	}
}

?>