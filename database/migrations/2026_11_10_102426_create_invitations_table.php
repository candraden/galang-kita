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
       Schema::create('invitations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('group_id')->constrained()->cascadeOnDelete();
    $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
    $table->string('token')->unique();
    $table->timestamp('expires_at')->nullable();
    $table->unsignedInteger('max_uses')->nullable();
    $table->unsignedInteger('used_count')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();
    $table->index(['group_id', 'is_active']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
