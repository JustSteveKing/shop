<?php

declare(strict_types=1);

namespace App\Providers;

use Domains\Customer\Projectors\CartProjector;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Projectionist::addProjectors([
            CartProjector::class
        ]);
    }

    public function boot(): void
    {
        //
    }
}
