<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $primaryKey = 'requirement_id';

    public function business_requirements()
    {
        return $this->hasMany(BusinessRequirement::class, 'requirement_id', 'requirement_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'office_id');
    }
}
