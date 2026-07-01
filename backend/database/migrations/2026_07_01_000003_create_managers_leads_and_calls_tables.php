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
        Schema::create('managers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->enum('status', ['new', 'in_progress', 'won', 'lost'])->default('new');
            $table->foreignId('manager_id')->nullable()->constrained('managers')->nullOnDelete();
        });

        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->unsignedInteger('duration');
            $table->enum('result', ['no_answer', 'callback_later', 'success']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
        Schema::dropIfExists('leads');
        Schema::dropIfExists('managers');
    }
};
