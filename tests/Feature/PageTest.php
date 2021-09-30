<?php

declare(strict_types=1);

use JustSteveKing\StatusCode\Http;

use function Pest\Laravel\get;

it('receives a HTTP OK on the home page', function () {
    get(
        uri: route('home'),
    )->assertStatus(
        status: Http::OK
    );
});
