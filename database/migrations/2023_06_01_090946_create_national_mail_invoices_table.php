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
        Schema::create('national_mail_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->integer('invoice_month');
            $table->integer('invoice_year');
            $table->enum('invoice_status', ['pending', 'paid', 'overdue']);
            $table->string('invoice_total');
            $table->string('invoice_ibm_attachment');
            $table->string('invoice_payment_date')->nullable();
            $table->enum('invoice_payment_status', ['pending', 'paid', 'overdue']);
            $table->string('invoice_payment_attachment')->nullable();
            $table->UnsignedBigInteger('customer');
            $table->foreign('customer')->references('id')->on('customers')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_mail_invoices');
    }
};
