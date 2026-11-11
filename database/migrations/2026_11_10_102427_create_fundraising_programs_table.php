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
        Schema::create('fundraising_programs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('group_id')->constrained()->cascadeOnDelete();
    $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->string('type'); // voluntary, fixed_dues, shared_savings, regular_cash, event_dues
    $table->decimal('target_amount', 15, 2)->nullable();
    $table->decimal('contribution_amount', 15, 2)->nullable();
    $table->string('period_type')->default('one_time'); // one_time, weekly, monthly
    $table->date('start_date')->nullable();
    $table->date('due_date')->nullable();
    $table->string('bank_name')->nullable();
    $table->string('account_number')->nullable();
    $table->string('account_holder')->nullable();
    $table->text('payment_notes')->nullable();
    $table->string('status')->default('draft'); // draft, active, closed, cancelled
    $table->timestamps();
    $table->softDeletes();
    $table->index(['group_id', 'status']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fundraising_programs');
    }
};
