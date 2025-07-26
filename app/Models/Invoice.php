<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'value',
        'number',
        'school_id'
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    // App\Models\Invoice.php

public function school()
{
    return $this->belongsTo(School::class);
}

}
