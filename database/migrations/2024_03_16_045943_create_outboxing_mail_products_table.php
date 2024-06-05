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
        Schema::create('outboxing_mail_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outboxing_id')->constrained('outboxing_mails')->restrictOnDelete();
            $table->integer('item_id');
            $table->string('country');
            $table->decimal('weight');
            $table->decimal('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outboxing_mail_products');
    }
};
