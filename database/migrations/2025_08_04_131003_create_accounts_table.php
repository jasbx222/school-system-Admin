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
        Schema::create('accounts', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('code')->unique(); // رقم الحساب
    $table->decimal('balance', 15, 2)->default(0.00);
    $table->foreignId('parent_id')->nullable()->constrained('accounts')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
