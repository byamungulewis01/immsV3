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
        Schema::create('virtual_boxes', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('branch_id');
            $table->enum('status', ['payee', 'impayee'])->default('impayee');
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email');
            $table->date('date');
            $table->string('pob_category');
            $table->string('pob_type');
            $table->integer('amount');
            $table->boolean('cotion')->default(false);
            $table->integer('year')->default(2023);
            $table->boolean('available')->default(false);
            $table->string('attachment')->nullable();
            $table->UnsignedBigInteger('customer_id');
            $table->foreign('branch_id')->references('id')->on('branches')->constrained()->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('virtual_boxes');
    }
};
