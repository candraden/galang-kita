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
        Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('obligation_id')->constrained('payment_obligations')->cascadeOnDelete();
    $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
    $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
    $table->decimal('amount', 15, 2);
    $table->date('transfer_date')->nullable();
    $table->string('sender_name')->nullable();
    $table->string('sender_bank')->nullable();
    $table->string('reference_number')->nullable();
    $table->string('proof_path')->nullable();
    $table->string('proof_hash')->nullable()->unique();
    $table->string('status')->default('pending'); // pending, approved, rejected
    $table->text('rejection_note')->nullable();
    $table->timestamp('submitted_at')->nullable();
    $table->timestamp('verified_at')->nullable();
    $table->timestamps();
    $table->index(['obligation_id', 'status']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
