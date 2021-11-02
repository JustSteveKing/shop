<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('variant_wishlist', function (Blueprint $table) {
            $table->foreignId('variant_id')->index()->constrained()->cascadeOnDelete();
            $table->foreignId('wishlist_id')->index()->constrained()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('variant_wishlist');
    }
};
