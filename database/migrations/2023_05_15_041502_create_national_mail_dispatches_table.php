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
        Schema::create('national_mail_dispatches', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('branch');
            $table->string('weight')->default('0');
            $table->integer('mailsNumber')->default(0);
            $table->integer('status')->default(0);
            $table->date('sentDate')->nullable();
            $table->UnsignedBigInteger('receivedBy')->nullable();
            $table->foreign('branch')->references('id')->on('branches')->constrained()->onDelete('cascade');
            $table->foreign('receivedBy')->references('id')->on('users')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('national_mail_dispatches');
    }
};
