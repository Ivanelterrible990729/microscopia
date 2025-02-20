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
        Schema::create('cnn_model_label', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cnn_model_id')->constrained(table: 'cnn_models')->cascadeOnDelete();
            $table->foreignId('label_id')->constrained(table: 'labels')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnn_model_label');
    }
};
