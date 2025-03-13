<?php

namespace Src\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qbwc_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->constrained('qbwc_queue')->onDelete('cascade');
            $table->string('task_class');
            $table->json('task_params')->nullable();
            $table->enum('iterator', ['Start', 'Continue', 'End'])->nullable();
            $table->string('iterator_id')->nullable();
            $table->unsignedInteger('loop_count')->default(0);
            $table->unsignedInteger('loops_remaining')->default(0);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->unsignedInteger('order');
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
