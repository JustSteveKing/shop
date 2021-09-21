<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_lines', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();

            $table->string('name');
            $table->mediumText('description');

            $table->unsignedInteger('retail');
            $table->unsignedInteger('cost');
            $table->unsignedInteger('quantity');

            $table->morphs('purchasable');
            $table->foreignId('order_id')->index()->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_lines');
    }
};
