<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Expense extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='expenses';
        public function category_expense()
    {
        return $this->belongsTo(CategoryExpense::class);
    }
        public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function entry(){
        return $this ->hasOne(Entry::class);
    }
}
