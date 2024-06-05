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
        Schema::create('outboxing_mails', function (Blueprint $table) {
            $table->id();
            $table->string('tracking');
            $table->string('snames');
            $table->string('sphone');
            $table->string('semail')->nullable();
            $table->string('snid')->nullable();
            $table->string('saddress')->nullable();
            $table->string('c_id');
            $table->string('rnames');
            $table->string('rphone');
            $table->string('remail')->nullable();
            $table->string('raddress')->nullable();
            $table->integer('status')->default(1);
            $table->date('tradate')->nullable();
            $table->date('recdate')->nullable();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('branch_id')->constrained()->restrictOnDelete();
            $table->enum('type',['ems','percel','registered','temble']);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outboxing_mails');
    }
};
