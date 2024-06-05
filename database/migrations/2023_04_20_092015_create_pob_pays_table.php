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
        Schema::create('pob_pays', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('box_id');
            $table->integer('amount');
            $table->integer('year');
            $table->enum('payment_type', ['rent', 'cert','key','cotion','ingufuri']);
            $table->string('payment_model');
            $table->enum('serviceType', ['PBox', 'VBox']);
            $table->UnsignedBigInteger('branch_id');
            $table->string('payment_ref')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->constrained()->onDelete('cascade');
            $table->foreign('box_id')->references('id')->on('boxes')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pob_pays');
    }
};
