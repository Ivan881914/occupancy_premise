<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('occupancy', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('timestamp');
            $table->integer('diff');
            $table->timestamps(); // добавляет created_at и updated_at

            // Индекс для ускорения поиска по времени
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
