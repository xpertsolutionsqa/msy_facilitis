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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('facility_id');
            $table->integer('days');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('UID');
            $table->string('event_name');
            $table->string('particpations');
            $table->string('cname');
            $table->string('cphone');
            $table->string('cemail');
            $table->longText('notes')->nullable();
            $table->longText('files')->nullable();
            $table->string('status')->default('1');
            $table->string('reject_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
