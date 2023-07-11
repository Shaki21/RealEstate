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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->decimal('price', 10);
            $table->integer('bedroom');
            $table->integer('bathroom');
            $table->integer('quadrature');
            $table->integer('floors');
            $table->integer('garden_quadrature');
            $table->string('address');
            $table->string('property_type');
            $table->string('property_status');
            $table->string('description');
            $table->string('cityName');
            $table->string('countryName');
            $table->foreign('cityName')->references('name')->on('cities');
            $table->foreign('countryName')->references('name')->on('countries');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
