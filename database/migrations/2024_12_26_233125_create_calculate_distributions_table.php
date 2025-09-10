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
        Schema::create('calculate_distributions', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('expenses_percentage');
            $table->string('expenses_value');
            $table->string('leisure_percentage');
            $table->string('leisure_value');
            $table->string('investments_percentage');
            $table->string('investments_value');
            $table->string('we_tithe_percentage');
            $table->string('we_tithe_value');
            $table->dateTime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculate_distributions');
    }
};
