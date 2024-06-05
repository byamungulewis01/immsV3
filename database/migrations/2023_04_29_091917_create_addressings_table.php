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
        Schema::create('addressings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('pob');
            $table->enum('customer_type', ['Individual', 'Company']);
            $table->string('address');
            $table->string('photo')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('longitude');
            $table->string('latitude');
            $table->enum('visible', ['public', 'private']);
            $table->UnsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->constrained()->onDelete('cascade');
            $table->string('index')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addressings');
    }
};
