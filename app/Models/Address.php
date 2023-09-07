<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $primaryKey = 'address_id';

    public function businesses()
    {
        return $this->hasMany(Business::class, 'address_id', 'address_id');
    }
}
