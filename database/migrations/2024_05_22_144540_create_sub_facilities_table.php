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
        Schema::create('sub_facilities', function (Blueprint $table) {
            $table->id();
            $table->integer('facility_id');
            $table->string('title');
            $table->longText('images')->nullable();
            $table->longText('description')->nullable();
            $table->string('size')->nullable();
            $table->integer('type')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_facilities');
    }
};
