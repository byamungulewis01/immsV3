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
        Schema::create('pob_backups', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pob');
            $table->UnsignedBigInteger('branch_id');
            $table->enum('size', ['Pte', 'Gde']);
            $table->enum('status', ['payee', 'impayee'])->default('impayee');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->date('date')->nullable();
            $table->string('pob_category')->nullable();
            $table->enum('serviceType', ['PBox', 'VBox']);
            $table->string('pob_type')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('cotion')->default(0);
            $table->integer('year');
            $table->boolean('available')->default(false);
            $table->string('attachment')->nullable();
            $table->string('profile')->nullable();
            $table->enum('visible', ['public', 'private'])->nullable();
            $table->string('homeAddress')->nullable();
            $table->string('homePhone')->nullable();
            $table->string('homeLocation')->nullable();
            $table->string('officeAddress')->nullable();
            $table->string('officePhone')->nullable();
            $table->string('officeLocation')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pob_backups');
    }
};
