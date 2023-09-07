<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessRequirement extends Model
{
    use HasFactory;

    protected $primaryKey = 'business_requirement_id';

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'business_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id', 'requirement_id');
    }
}
