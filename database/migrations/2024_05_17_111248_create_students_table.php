<?php

use App\Enums\Gender;
use App\Enums\StudentStatus;
use App\Enums\YesOrNoAnswer;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('mother_name');
            $table->unsignedBigInteger('school_id');
            $table->text('profile_image_url')->nullable();
            $table->text('file')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', StudentStatus::SET)->default(StudentStatus::CONTINUOUS);
            $table->enum('gender', Gender::SET)->default(Gender::MALE);
            $table->enum('orphan', YesOrNoAnswer::SET)->default(YesOrNoAnswer::NO);
            $table->enum('has_martyrs_relatives', YesOrNoAnswer::SET)->default(YesOrNoAnswer::NO);
            $table->string('last_school')->nullable();
            $table->unsignedBigInteger('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->unsignedBigInteger('class_room_id');
            $table->foreign('class_room_id')->references('id')->on('class_rooms')->onDelete('cascade');
            $table->unsignedBigInteger('class_section_id');
            $table->foreign('class_section_id')->references('id')->on('class_sections')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->date('birth_day');
   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
