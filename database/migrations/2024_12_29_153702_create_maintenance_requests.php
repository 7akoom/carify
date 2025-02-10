<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->enum('type', \App\Enums\MaintenanceTypes::values());
            $table->date('date');
            $table->string('reference')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('total');
            $table->string('notes')->nullable();
            $table->string('created_by');
            $table->string('odometer_number');
            $table->time('time');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->foreignId('truck_id')->constrained();
            $table->foreignId('driver_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_requests');
    }
};
