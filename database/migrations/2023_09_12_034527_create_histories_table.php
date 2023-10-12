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
        Schema::create('histories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial')->nullable();
            $table->dateTime('date_issued');
            $table->dateTime('return_date')->nullable();
            $table->string('status');
            $table->string('issued_to'); 
            $table->string('model');
            $table->integer('price');
            $table->dateTime('mfg_date');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('histories');
    }
};
