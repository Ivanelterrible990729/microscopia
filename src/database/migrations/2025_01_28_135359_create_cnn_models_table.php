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
        Schema::create('cnn_models', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('base_model')->nullable();
            $table->decimal('accuracy', 5, 4)->nullable();
            $table->decimal('loss', 5, 4)->nullable();
            $table->decimal('val_accuracy', 5, 4)->nullable();
            $table->decimal('val_loss', 5, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cnn_models');
    }
};
