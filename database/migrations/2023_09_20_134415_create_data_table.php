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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('date');
            $table->integer('issued_item')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->string('description');
            $table->string('status');
            $table->string('issued_to')->nullable();    
            $table->integer('count');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
