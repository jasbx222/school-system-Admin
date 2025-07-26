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
       Schema::create('entries', function (Blueprint $table) {
    $table->id();
    $table->foreignId('box_id')->constrained('boxes')->onDelete('cascade');
    $table->foreignId('expense_id')->nullable()->constrained('expenses')->onDelete('set null');
    $table->enum('type', ['debit', 'credit']); // debit = مدين, credit = دائن
    $table->decimal('amount', 15, 2);
    $table->text('description')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
