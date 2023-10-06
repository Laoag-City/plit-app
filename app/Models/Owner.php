<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Owner extends Model implements Searchable
{
    use HasFactory;

    protected $primaryKey = 'owner_id';

    public function businesses()
    {
        return $this->hasMany(Business::class, 'owner_id', 'owner_id');
    }

    public function getSearchResult(): SearchResult
    {
        return new SearchResult($this, $this->name);
    }
}
