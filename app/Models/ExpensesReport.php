<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensesReport extends Model
{
    use HasFactory;
      protected $fillable = [
        'expense_id',
        'report_date',
        'notes',
    ];

    // علاقة التقرير بالمصروف
    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
}
