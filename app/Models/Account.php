<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// app/Models/Account.php

class Account extends Model
{
    protected $fillable = ['name', 'code', 'parent_id', 'school_id','type','balance'];

    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }
public function school()
{
    return $this->belongsTo(School::class);
}


    public function children()
    {
        return $this->hasMany(Account::class, 'parent_id');
    }
    // في Account.php

public function childrenRecursive()
{
   return $this->children()->with('childrenRecursive');
} 

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
    public function paymentVouchers()
    {
        return $this->hasMany(PaymentVoucher::class);
    }
}

