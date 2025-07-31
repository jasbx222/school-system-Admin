<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\School;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

     
        // School::factory(1)->create();
        //    User::factory(1)->create();
        // ClassRoom::create([
        //     'title'=>'a',

        //     'school_id'=>1,
        // ]);
        // ClassSection::create([
        //     'title'=>'a',
        //     'class_room_id'=>4,

        //     'school_id'=>1,
        // ]);
        // Semester::create([
        //     'title'=>'a',
        //     'from'=>date(now()),
        //     'school_id'=>1,
        //     'to'=>date(now()->month()),

        // ]);
        Student::factory(50)->create();
    }
}
