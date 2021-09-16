<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('billing_id')->after('remember_token')->index()->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('shipping_id')->after('billing_id')->index()->nullable()->constrained('addresses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'billing_id',
                'shipping_id'
            ]);

            $table->dropIndex([
                'billing_id',
                'shipping_id',
            ]);
        });
    }
};
