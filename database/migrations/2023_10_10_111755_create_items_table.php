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
            $table->foreignId('parent_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('model');
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->string('serial');
            $table->string('status');
            $table->dateTime('mfg_date')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('location')->nullable();
            $table->string('warranty')->nullable();
            $table->string('insurance')->nullable();
            $table->decimal('net_weight', 10, 2)->default(0)->nullable();
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
