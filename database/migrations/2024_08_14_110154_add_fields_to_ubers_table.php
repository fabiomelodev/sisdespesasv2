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
        Schema::table('ubers', function (Blueprint $table) {
            $table->integer('level')->nullable();
            $table->string('route_initial')->nullable();
            $table->string('route_final')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ubers', function (Blueprint $table) {
            //
        });
    }
};
