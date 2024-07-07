<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('qbwc_queue')->create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->constrained('queues')->onDelete('cascade');
            $table->string('task_class');
            $table->json('task_params');
            $table->enum('iterator', ['Start', 'Continue'])->nullable();
            $table->string('iterator_id')->nullable();
            $table->int('loop_count')->nullable();
            $table->int('loops_remaining')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->integer('order');
            $table->text('error_message')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('qbwc_queue')->dropIfExists('tasks');
    }
};