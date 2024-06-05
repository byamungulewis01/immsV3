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
        Schema::create('inboxing_reports', function (Blueprint $table) {
            $table->id();
            $table->string('mailtype');
            $table->integer('inMails')->default(0);
            $table->integer('outMails')->default(0);
            $table->integer('balance')->default(0);
            $table->integer('branch');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inboxing_reports');
    }
};
