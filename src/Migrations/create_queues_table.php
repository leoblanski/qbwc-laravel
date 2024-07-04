<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('qbwc_queue')->create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('total_tasks')->nullable();
            $table->integer('tasks_completed')->default(0);
            $table->integer('tasks_failed')->default(0);
            $table->timestamp('initialized_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('qbwc_queue')->dropIfExists('queues');
    }
};
