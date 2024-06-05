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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->enum('level', ['register', 'backOffice','branchManager','pob','airport','cntp','driver','administrative'])->nullable()->after('remember_token');
            $table->enum('office', ['o', 'r','p','ems'])->nullable()->after('level');
            $table->string('driving_license')->nullable()->after('office');
            $table->string('driving_category')->nullable()->after('driving_license');
            $table->enum('driverRole', ['chief', 'driver'])->nullable()->after('driving_category');
            $table->UnsignedBigInteger('vehicle_id')->nullable()->after('driverRole');
            $table->boolean('block')->default(0)->after('vehicle_id');
            $table->softDeletes()->after('block');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
