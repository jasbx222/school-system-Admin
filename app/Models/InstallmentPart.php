<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InstallmentPart extends Model
{
    protected $fillable = [
        'installment_id',
        'amount',
        'due_date',
        'paid_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
