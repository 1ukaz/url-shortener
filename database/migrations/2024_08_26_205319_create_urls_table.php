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
        Schema::create('urls', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();
            $table->string('original_url');
            $table->string('shortened_url');
            $table->string('user_identifier');
            $table->timestamps();
        
            // Definir la clave foránea para la relación con la tabla `users`
            $table->foreign('user_identifier')->references('identifier')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('urls');
    }
};
