<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public function PropertyType()
    {
        return $this->belongsTo(PropertyType::class, 'ptype_id', 'id');
    }
}
