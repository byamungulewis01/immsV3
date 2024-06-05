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
        Schema::table('boxes', function (Blueprint $table) {
            $table->enum('homeVisible', ['public', 'private'])->nullable()->after('homeLocation');
            $table->string('homeEmail')->nullable()->after('homeVisible');
            $table->enum('officeVisible', ['public', 'private'])->nullable()->after('officeLocation');
            $table->string('officeEmail')->nullable()->after('officeVisible');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('boxes', function (Blueprint $table) {
            //
        });
    }
};
