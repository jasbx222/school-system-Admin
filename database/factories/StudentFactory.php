<?php

namespace Database\Factories;

use App\Models\Student;
use App\Enums\Gender;
use App\Enums\StudentStatus;
use App\Enums\YesOrNoAnswer;
use App\Models\ClassRoom;
use App\Models\ClassSection;
use App\Models\Semester;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [


            'full_name' => $this->faker->name(),
            'mother_name' => $this->faker->firstNameFemale(),
            'school_id' => 1,
            'profile_image_url' => $this->faker->imageUrl(),
            'file' => $this->faker->filePath(), // أو null
            'description' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(StudentStatus::SET),
            'gender' => $this->faker->randomElement(Gender::SET),
            'orphan' => $this->faker->randomElement(YesOrNoAnswer::SET),
            'has_martyrs_relatives' => $this->faker->randomElement(YesOrNoAnswer::SET),
            'last_school' => $this->faker->company(),
            'semester_id' => DB::table('semesters')->inRandomOrder()->value('id'),
            'class_room_id' => DB::table('class_rooms')->inRandomOrder()->value('id'),
            'class_section_id' => DB::table('class_sections')->inRandomOrder()->value('id'),

            'birth_day' => $this->faker->date('Y-m-d', '2015-01-01'),
        ];
    }
}
