<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    protected $fillable = ['box_id', 'expense_id', 'type', 'amount', 'description'];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }
  
}
