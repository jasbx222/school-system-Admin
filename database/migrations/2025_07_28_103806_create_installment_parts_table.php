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
       Schema::create('installment_parts', function (Blueprint $table) {
    $table->id();
    $table->foreignId('installment_id')->constrained('installments')->cascadeOnDelete();
    $table->decimal('amount');
    $table->date('due_date');
    $table->timestamp('paid_at')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installment_parts');
    }
};
