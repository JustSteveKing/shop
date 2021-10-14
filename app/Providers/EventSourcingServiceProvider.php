<?php

declare(strict_types=1);

namespace App\Providers;

use Domains\Customer\Projectors\CartProjector;
use Domains\Fulfilment\Projectors\OrderProjector;
use Illuminate\Support\ServiceProvider;
use Spatie\EventSourcing\Facades\Projectionist;

class EventSourcingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Projectionist::addProjectors([
            CartProjector::class,
            OrderProjector::class,
        ]);
    }

    public function boot(): void
    {
        //
    }
}
