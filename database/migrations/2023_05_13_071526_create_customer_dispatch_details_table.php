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
        Schema::create('customer_dispatch_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dispatch_id');
            $table->string('dispatchNumber');
            $table->string('refNumber', 7)->unique()->default('NP-0001');
            $table->string('weight')->default('0');
            $table->string('price')->default('0');
            $table->string('observation')->nullable();
            $table->integer('status')->default(0)->comment('0: Registed, 1: Picked Up, 2: Logistic processed, 3: EMS National, 4: To Branch Mananger, 5: Delivered');
            // pick up
            $table->string('pickUpDate')->nullable();
            // logistic
            $table->string('logisticDate')->nullable();
            // ems
            $table->string('emsDate')->nullable();
            // branch manager
            $table->string('branchManagerDate')->nullable();
            // delivered
            $table->string('deliveredDate')->nullable();
            // pob
            $table->integer('pob')->nullable();
            // customer_id
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('destination_id');
            $table->foreign('dispatch_id')->references('id')->on('customer_dispatches')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('my_contacts')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_dispatch_details');
    }
};
