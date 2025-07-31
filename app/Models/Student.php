<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name',
        'mother_name',
        'last_school',
        'semester_id',
        'class_section_id',
        'class_room_id',
        'birth_day',
        'profile_image_url',
        'description',
        'status',
        'orphan',
        'has_martyrs_relatives',
        'gender',
        'file',
        'school_id',
    ];
    public function offer()
    {
        return $this->hasMany(Offer::class);
    }
    public function classSection()
    {
        return $this->belongsTo(ClassSection::class);
    }
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function getSumOfAttendancesWithStatusFalseAttribute()
    {
        return $this->attendances->where('status', AttendanceStatus::ABSENT)->count();
    }
    public function getSumOfAttendancesWithStatusTrueAttribute()
    {
        return $this->attendances->where('status', AttendanceStatus::PRESENT)->count();
    }
    public function getFileAttribute($value)
    {
        return $value ? url('storage/' . $value) : 'لايوجد ملف مرفق';
    }
    public function getSumOfInvoicesAttribute()
    {
        return $this->invoices()->sum('value');
    }
   
   

   

    public function attendanceSummary()
{
    return $this->attendances()
        ->selectRaw('status, count(*) as total')
        ->groupBy('status');
}
public function installments(){
    return $this->hasMany(Installment::class);
}

public function result (){
    return $this->hasOne(Result::class);

}
}
