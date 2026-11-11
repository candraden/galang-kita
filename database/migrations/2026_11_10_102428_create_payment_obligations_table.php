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
        Schema::create('payment_obligations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('program_id')->constrained('fundraising_programs')->cascadeOnDelete();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('period_label')->default('once');
    $table->decimal('amount', 15, 2);
    $table->date('due_date')->nullable();
    $table->string('status')->default('unpaid'); // unpaid, pending, paid, rejected
    $table->timestamps();
    $table->unique(['program_id', 'user_id', 'period_label']);
    $table->index(['user_id', 'status']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_obligations');
    }
};
