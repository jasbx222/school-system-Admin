<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $fillable = [
        'title',
        'amount',
        'student_id',
        'school_id',
        'status',
  
    ];

    public function parts()
    {
        return $this->hasMany(InstallmentPart::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
