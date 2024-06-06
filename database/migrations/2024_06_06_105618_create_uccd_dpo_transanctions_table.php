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
        Schema::create('uccd_dpo_transanctions', function (Blueprint $table) {
            $table->id();
            $table->string('trans_token');
            $table->string('trans_ref');
            $table->string('phone');
            $table->string('meter_number');
            $table->bigInteger('amount');
            $table->enum('status',['new','success','fail'])->default('new');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uccd_dpo_transanctions');
    }
};
