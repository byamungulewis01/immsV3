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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pob');
            $table->UnsignedBigInteger('branch_id');
            $table->enum('status', ['payee', 'impayee'])->default('impayee');
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->string('pob_category');
            $table->string('pob_type');
            $table->integer('amount');
            $table->integer('year');
            $table->string('attachment');
            $table->enum('is_new_customer', ['yes', 'no']);
            $table->boolean('aprooved')->default(false);
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
        Schema::dropIfExists('applications');
    }
};
