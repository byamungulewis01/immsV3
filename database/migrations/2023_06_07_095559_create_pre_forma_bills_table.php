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
        Schema::create('pre_forma_bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_number');
            $table->string('non_pay_years');
            $table->decimal('rental_amount', 8, 2);
            $table->decimal('total_amount', 8, 2);
            $table->UnsignedBigInteger('box');
            $table->foreign('box')->references('id')->on('boxes')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_forma_bills');
    }
};
