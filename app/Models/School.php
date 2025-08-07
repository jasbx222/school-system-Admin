<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function class_sections()
    {
        return $this->hasMany(ClassSection::class);
    }
    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }
    
  
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }
    public function getCountOfMaleStudentAttribute()
    {
        return $this->students->where('gender', Gender::MALE)->count();
    }
    public function getCountOfFemaleStudentAttribute()
    {
        return $this->students->where('gender', Gender::FEMALE)->count();
    }
  
    public function student_transfers(){
        return $this->hasMany(StudentTransfer::class);
    }
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }
    public function paymentVouchers()
    {
        return $this->hasMany(PaymentVoucher::class);
    }
 public function accounts()
{
    return $this->hasMany(Account::class);
}





//كل مدرسة يتم إنشاؤها، سواء من لوحة التحكم أو من seeder أو API، تنشأ لها نسخة مستقلة من شجرة الحسابات.

//كل حساب مربوط بـ school_id
protected static function booted()
{
    static::created(function ($school) {
        $accounts = json_decode(File::get(database_path('seeders/chart_of_accounts.json')), true);
        foreach ($accounts['accounts'] as $account) {
            self::createAccountTree($account, $school->id);
        }
    });
}

// نضيف هذه دالة داخل نفس موديل School
public static function createAccountTree(array $data, $schoolId, $parentId = null): void
{
    $account = \App\Models\Account::create([
        'code' => $data['code'],
        'name' => $data['name'],
        'parent_id' => $parentId,
        'type' => $data['type'] ?? null,
        'school_id' => $schoolId,
    ]);

    if (isset($data['children'])) {
        foreach ($data['children'] as $child) {
            self::createAccountTree($child, $schoolId, $account->id);
        }
    }
}













}
