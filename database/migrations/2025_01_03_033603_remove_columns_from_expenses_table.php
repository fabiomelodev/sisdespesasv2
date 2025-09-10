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
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn('credit');
            $table->dropColumn('means_payment');
            $table->dropColumn('uber_route_initial');
            $table->dropColumn('uber_route_final');
            $table->dropColumn('uber_importance');
            $table->dropColumn('automobile');
            $table->dropColumn('ref');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            //
        });
    }
};
