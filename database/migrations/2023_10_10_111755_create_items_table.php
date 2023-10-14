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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('parent_models')->onDelete('cascade');
            $table->string('name');
            $table->string('model');
            $table->integer('price');
            $table->dateTime('mfg_date');
            $table->string('serial');
            $table->string('status');
            $table->string('barcode');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
