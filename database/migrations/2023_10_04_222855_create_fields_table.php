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
        Schema::create('fields', function (Blueprint $table) {
            $table->id();
             $table->foreignId('field_groups_id')->constrained('field_groups')->onDelete('cascade'); 
            $table->string('label')->nullable();
            $table->string('name')->nullable();
            $table->string('value')->nullable();
            $table->longText('description');
            $table->string('is_required');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fields');
    }
};
