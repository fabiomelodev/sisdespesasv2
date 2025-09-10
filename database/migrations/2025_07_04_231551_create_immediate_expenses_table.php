<?php

use App\Models\Bank;
use App\Models\Category;
use App\Models\MeanPayment;
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
        Schema::create('immediate_expenses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('value');
            $table->dateTime('pay_day')->nullable();
            $table->foreignIdFor(Bank::class)->nullable();
            $table->foreignIdFor(Category::class);
            $table->foreignIdFor(MeanPayment::class)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('immediate_expenses');
    }
};
