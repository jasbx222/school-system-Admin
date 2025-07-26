<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryExpense extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'description',
        'school_id'
    ];
    protected $table='category_expenses';

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public  function school(){
        return $this->belongsTo(School::class);
    }
}
