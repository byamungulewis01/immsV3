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
        Schema::create('home_deliveries', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('customer');
            $table->integer('pob');
            $table->string('addressOfDelivery');
            $table->integer('status')->default(0);
            $table->UnsignedBigInteger('inboxing');
            $table->UnsignedBigInteger('box_id');
            $table->foreign('box_id')->references('id')->on('boxes')->constrained()->onDelete('cascade');
            $table->foreign('inboxing')->references('id')->on('inboxings')->constrained()->onDelete('cascade');
            $table->foreign('customer')->references('id')->on('customers')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_deliveries');
    }
};
