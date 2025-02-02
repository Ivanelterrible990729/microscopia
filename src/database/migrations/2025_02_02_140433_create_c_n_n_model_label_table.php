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
        Schema::create('c_n_n_model_label', function (Blueprint $table) {
            $table->id();
            $table->foreignId('c_n_n_model_id')->constrained(table: 'c_n_n_models');
            $table->foreignId('label_id')->constrained(table: 'labels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_n_n_model_label');
    }
};
