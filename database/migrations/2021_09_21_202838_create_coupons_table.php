<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->string('code'); // 'gimmie-money-off
            $table->unsignedInteger('reduction')->default(0); // 5000
            $table->unsignedInteger('uses')->default(0); // 2
            $table->unsignedInteger('max_uses')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
