<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    protected $primaryKey = 'classification_id';

    public function businesses()
    {
        return $this->hasMany(Business::class, 'classification_id', 'classification_id');
    }
}
