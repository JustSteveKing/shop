<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('house'); // 12334
            $table->string('street'); // Street Name
            $table->string('parish')->nullable(); // Belper
            $table->string('ward')->nullable(); // Belper South
            $table->string('district')->nullable(); // Amber Valley
            $table->string('county')->nullable(); // Derbyshire County
            $table->string('postcode'); // DE56 0QF
            $table->string('country'); // United Kingdom
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
