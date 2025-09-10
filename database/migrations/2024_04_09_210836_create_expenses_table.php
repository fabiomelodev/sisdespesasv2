<?php

use App\Models\{Bank, Category};
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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('credit')->nullable();
            $table->string('means_payment')->nullable();
            $table->string('value');
            $table->dateTime('pay_day')->nullable();
            $table->string('type');
            $table->string('status')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->foreignIdFor(Bank::class)->nullable();
            $table->foreignIdFor(Category::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
