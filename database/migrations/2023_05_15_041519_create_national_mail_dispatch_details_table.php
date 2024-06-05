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
        Schema::create('national_mail_dispatch_details', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('dispatch');
            $table->UnsignedBigInteger('customerMail');
            $table->UnsignedBigInteger('customer_id');
            $table->date('dateReceived')->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('status')->default(0);
            $table->foreign('dispatch')->references('id')->on('national_mail_dispatches')->constrained()->onDelete('cascade');
            $table->foreign('customerMail')->references('id')->on('customer_dispatch_details')->constrained()->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_mail_dispatch_details');
    }
};
