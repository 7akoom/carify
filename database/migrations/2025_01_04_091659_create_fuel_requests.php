<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fuel_requests', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('number');
            $table->foreignId('truck_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->integer('prev_odometer_number')->nullable();
            $table->integer('curr_odometer_number');
            $table->float('amount');
            $table->integer('distance')->nullable();
            $table->integer('distance_ratio')->nullable();
            $table->integer('estimated_distance_ratio')->nullable();
            $table->time('time');
            $table->string('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fuel_requests');
    }
};
