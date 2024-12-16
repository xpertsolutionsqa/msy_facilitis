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
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->integer('facility_id');
            $table->string('requester');
            $table->integer('request_status')->default(1);
            $table->integer('status')->default(1);
            $table->timestamp('startDate')->nullable();
            $table->timestamp('endDate')->nullable();
            $table->longText('team')->default(0);
            $table->longText('description')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
