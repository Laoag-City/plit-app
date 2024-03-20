<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Spatie\Searchable\Search;

class SearchController extends Controller
{
    public function getSearchResults(Request $request): View
    {
        Validator::make($request->all(), [
            'keyword' => 'bail|required|string|min:3'
        ])->validate();

        $owners = (new Search())
                        ->registerModel(Owner::class, 'name')
                        ->search($request->keyword)
                        ->pluck('searchable');

        $businesses = (new Search())
                        ->registerModel(Business::class, ['id_no', 'name', 'location_specifics'])
                        ->search($request->keyword)
                        ->pluck('searchable');

        return view('search-results', [
            'businesses' => $businesses,
            'owners' => $owners
        ]);
    }
}
