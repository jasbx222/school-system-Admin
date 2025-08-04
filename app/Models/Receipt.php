<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'amount',
        'method',
        'receipt_number',
        'notes',
        'school_id',
    ];
    protected $table = 'receipts';
    protected $casts = [
        'amount' => 'decimal:2',
    ];
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
