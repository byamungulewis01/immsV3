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
        Schema::create('national_mails', function (Blueprint $table) {
            $table->id();
            $table->string('dispatchNumber');
            $table->date('dispatchDate');
            $table->UnsignedBigInteger('customer_id');
            $table->UnsignedBigInteger('destination_id');
            $table->integer('status')->default(0);
            $table->string('refNumber')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('price')->default(0);
            $table->string('observation')->nullable();
            $table->string('token')->nullable();
            $table->date('sentDate')->nullable();
            $table->date('deliveryDate')->nullable();
            $table->UnsignedBigInteger('postAgent')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->constrained()->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('my_contacts')->constrained()->onDelete('cascade');
            $table->foreign('postAgent')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_mails');
    }
};
