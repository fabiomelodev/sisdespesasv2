<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Bank;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ubers', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('means_payment')->nullable();
            $table->dateTime('pay_day')->nullable();
            $table->foreignIdFor(Bank::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ubers');
    }
};
