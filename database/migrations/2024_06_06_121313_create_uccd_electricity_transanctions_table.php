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
        Schema::create('uccd_electricity_transanctions', function (Blueprint $table) {
            $table->id();
            $table->string("customer_name");
            $table->string("customer_phone");
            $table->string("reference_number");
            $table->bigInteger("amount");
            $table->string("token");
            $table->string('token_p31')->nullable();
            $table->string('token_p32')->nullable();
            $table->double('units');
            $table->string('external_transaction_id')->nullable();
            $table->string('residential_rate')->nullable();
            $table->double('units_rate')->nullable();
            $table->string('request_id')->nullable();
            $table->string('eucl_status')->default('SUCCESSFUL');
            $table->string('electricity')->nullable();
            $table->string('tva')->nullable();
            $table->string('fees')->nullable();
            $table->string('date_from_eucl')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uccd_electricity_transanctions');
    }
};
