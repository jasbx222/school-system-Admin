<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table='subjects';
    protected $fillable=[
        'title',
        'class_room_id',
        'school_id'
    ];

    public function classRoom(){

       return $this->belongsTo(ClassRoom::class);
    }
}
