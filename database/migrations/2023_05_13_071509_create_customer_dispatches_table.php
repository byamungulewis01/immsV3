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
        Schema::create('customer_dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('dispatchNumber');
            $table->string('senderName');
            $table->string('senderPhone');
            $table->integer('senderPOBox');
            $table->integer('mailsNumber')->default(0);
            $table->string('weight')->default('0');
            $table->string('price')->default('0');
            $table->string('observation')->nullable();
            $table->integer('securityCode')->nullable();
            $table->date('sentDate')->nullable();
            $table->date('deliveryDate')->nullable();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('postAgent')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('postAgent')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_dispatches');
    }
};
