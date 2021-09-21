<?php

declare(strict_types=1);

namespace App\Providers;

use Domains\Catalog\Models\Variant;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'variant' => Variant::class,
        ]);
    }
}
