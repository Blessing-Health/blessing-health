<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('account_no')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('mobile')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->date('dob')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('occupation')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('locality')->nullable();
            $table->string('address')->nullable();
            $table->string('pin')->nullable();
            $table->foreignId('area_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
