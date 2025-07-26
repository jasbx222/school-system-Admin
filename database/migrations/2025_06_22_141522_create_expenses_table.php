<?php

use App\Enums\Payment;
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
        Schema::create('expenses', function (Blueprint $table) {
    $table->id();
    $table->string('title');                
    $table->decimal('amount', 10, 2);       
    $table->date('date'); 
    
    // أضف هذا السطر لتعريف العمود
    $table->unsignedBigInteger('school_id');
    
    // بعد تعريف العمود يمكنك إضافة المفتاح الأجنبي
    $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    
    $table->text('description')->nullable(); 
    $table->unsignedBigInteger('category_expense_id'); 
        $table->enum('status', Payment::SET)->default(Payment::GAVE);
    $table->timestamps();

    $table->foreign('category_expense_id')->references('id')->on('category_expenses')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
