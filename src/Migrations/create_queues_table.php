<?php

namespace Src\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qbwc_queue', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file')->nullable();
            $table->string('ticket')->nullable();
            $table->boolean('initialized')->default(false);
            $table->unsignedInteger('total_tasks')->nullable();
            $table->unsignedInteger('tasks_completed')->default(0);
            $table->unsignedInteger('tasks_failed')->default(0);
            $table->timestamp('initialized_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qbwc_queue');
    }
};
