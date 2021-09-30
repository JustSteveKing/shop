<?php

declare(strict_types=1);

namespace Tests;

use Closure;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param Closure|string $uri
     *
     */
    public function get($uri, array $headers = []): \Illuminate\Testing\TestResponse
    {
        return parent::get(
            uri: value(value: $uri),
            headers: $headers,
        );
    }

    /**
     * @param Closure|string $uri
     *
     */
    public function post($uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        return parent::post(
            uri: value(value: $uri),
            data: $data,
            headers: $headers,
        );
    }

    /**
     * @param Closure|string $uri
     *
     */
    public function patch($uri, array $data = [], array $headers = []): \Illuminate\Testing\TestResponse
    {
        return parent::patch(
            uri: value(value: $uri),
            data: $data,
            headers: $headers,
        );
    }
}
