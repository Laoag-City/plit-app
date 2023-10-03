<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $primaryKey = 'owner_id';

    public function businesses()
    {
        return $this->hasMany(Business::class, 'owner_id', 'owner_id');
    }

    public function ownerSearch($search)
    {
        
    }
}
