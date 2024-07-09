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
        Schema::create('daily_records', function (Blueprint $table) {
            $table->date('date')->primary();
            $table->unsignedInteger('male_count');
            $table->unsignedInteger('female_count');
            $table->unsignedInteger('male_avg_age');
            $table->unsignedInteger('female_avg_age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_records');
    }
};
