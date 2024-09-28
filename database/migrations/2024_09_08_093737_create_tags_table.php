<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('canonical')->unique();
            $table->tinyInteger('publish')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
