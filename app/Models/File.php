<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = 'file';

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Checker()
    {
        return $this->belongsTo(User::class, 'checker_id', 'id');
    }
}
