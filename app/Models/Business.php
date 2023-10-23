<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $primaryKey = 'business_id';

    public function business_requirements()
    {
        return $this->hasMany(BusinessRequirement::class, 'business_id', 'business_id');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'owner_id', 'owner_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id', 'address_id');
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class, 'classification_id', 'classification_id');
    }

    public function image_uploads()
    {
        return $this->hasMany(ImageUpload::class, 'business_id', 'business_id');
    }

    public function getInspectionStatus()
    {
        if($this->inspection_count == 0)
            return 'No inspection records yet.';
        elseif($this->inspection_count == 1)
            return 'Initial Inspection conducted. With deficiencies.';
        elseif($this->inspection_count == 2)
            return 'Re-inspection conducted. For closure.';
        elseif($this->inspection_count == 3)
            return 'All inspection conducted. Business has complied to all requirements.';
    }
}
