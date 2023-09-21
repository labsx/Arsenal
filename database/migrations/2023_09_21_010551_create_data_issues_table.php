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
        Schema::create('data_issues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('issued_date');
            $table->string('status');
            $table->string('issued_to');    
            $table->integer('count'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_issues');
    }
};
