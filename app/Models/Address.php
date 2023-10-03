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

    public function transformForSelectField() : array
    {
        return $this->all()
                    ->transform(function($item, $key){
                        return [
                            'value' => $item->brgy_no,
                            'name' => $item->brgy
                        ];
                    })->toArray();
    }
}
