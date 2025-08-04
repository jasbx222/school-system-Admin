<?php

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
       Schema::create('student_transfers', function (Blueprint $table) {
    $table->id();

    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    $table->foreignId('school_id')->constrained('schools')->onDelete('cascade');

    $table->foreignId('from_class_room_id')->constrained('class_rooms');
    $table->foreignId('from_class_section_id')->constrained('class_sections');

    $table->date('transfer_date')->nullable();
    $table->foreignId('to_class_room_id')->constrained('class_rooms');
    $table->foreignId('to_class_section_id')->constrained('class_sections');

    $table->timestamps();
});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportations');
    }
};
