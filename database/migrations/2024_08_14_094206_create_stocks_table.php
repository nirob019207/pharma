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
        Schema::create('stocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pharmacy_id');
            $table->unsignedBigInteger('medicine_id');
            $table->integer('quantity');
            $table->integer('unit_price');
            
            $table->enum('type', ['received', 'supplied']);
            $table->timestamps();

            $table->foreign('pharmacy_id')->references('id')->on('pharmachies');
            $table->foreign('medicine_id')->references('id')->on('medicines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
