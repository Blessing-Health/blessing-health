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
        Schema::create('mitras', function (Blueprint $table) {
            $table->id();
            $table->text('mitra_unique_id')->unique();
            $table->string('name');
            $table->string('mobile');
            $table->string('email')->nullable()->unique();
            $table->string('area')->nullable();
            $table->string('landmark')->nullable();
            $table->string('dist')->nullable();
            $table->string('state')->nullable();
            $table->string('pin')->nullable();
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
        Schema::dropIfExists('mitras');
    }
};
