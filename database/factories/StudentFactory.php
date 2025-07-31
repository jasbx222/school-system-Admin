<?php

namespace Database\Factories;

use App\Models\Student;
use App\Enums\Gender;
use App\Enums\StudentStatus;
use App\Enums\YesOrNoAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name(),
            'mother_name' => $this->faker->firstNameFemale(),
            'school_id' =>1,
            'profile_image_url' => $this->faker->imageUrl(),
            'file' => $this->faker->filePath(), // أو null
            'description' => $this->faker->optional()->sentence(),
            'status' => $this->faker->randomElement(StudentStatus::SET),
            'gender' => $this->faker->randomElement(Gender::SET),
            'orphan' => $this->faker->randomElement(YesOrNoAnswer::SET),
            'has_martyrs_relatives' => $this->faker->randomElement(YesOrNoAnswer::SET),
            'last_school' => $this->faker->company(),
            'semester_id' => 1,
            'class_room_id' => 4,
            'class_section_id' =>2,
            'birth_day' => $this->faker->date('Y-m-d', '2015-01-01'),
        ];
    }
}
