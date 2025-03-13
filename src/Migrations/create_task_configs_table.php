<?php

namespace Src\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qbwc_task_configs', function (Blueprint $table) {
            $table->id();
            $table->string('queue_name');
            $table->string('task_class');
            $table->json('task_params')->nullable();
            $table->boolean('iterate')->default(false);
            $table->unsignedInteger('order');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('task_configs');
    }
};
