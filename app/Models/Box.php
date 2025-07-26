<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable =['amount','school_id'];
    protected $table='boxes';
    use HasFactory;

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
