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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string("customer_name")->nullable();
            $table->string("customer_phone")->nullable();
            $table->string("reference_number")->nullable();
            $table->decimal("amount",18,0)->default(0)->nullable();
            $table->decimal("charges")->default(0)->nullable();
            $table->string("charges_type")->nullable();
            $table->string("status")->nullable();
            $table->string("token")->nullable();
            $table->string('token_p31')->nullable();
            $table->string('token_p32')->nullable();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->unsignedBigInteger("branch_id")->nullable();
            $table->foreign("user_id")->references("id")->on("users");
            $table->foreign("branch_id")->references("id")->on("branches");
            $table->decimal("total_charges")->default(0)->nullable();
            $table->boolean('is_exclusive')->default(false);
            $table->decimal('external_branch_commission', 10, 2)->nullable();
            $table->string('customer_email')->nullable();
            $table->double('units')->nullable();
            $table->string('internal_transaction_id')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
