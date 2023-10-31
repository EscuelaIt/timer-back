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
        Schema::create('category_interval', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained();
            $table->foreignId('interval_id')->constrained();
            $table->unique(['category_id', 'interval_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_interval');
    }
};
