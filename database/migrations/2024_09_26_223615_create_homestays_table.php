<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('homestays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price')->nullable(0);
            $table->longText('address')->nullable();
            $table->integer('open_hours')->nullable();
            $table->integer('total_rooms')->nullable();
            $table->integer('current_guests')->nullable();
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->tinyInteger('publish')->default(1);
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('homestays');
    }
};
