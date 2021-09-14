<?php

declare(strict_types=1);

namespace Database\Factories;

use Domains\Customer\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use JustSteveKing\LaravelPostcodes\Service\PostcodeService;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $service = resolve(PostcodeService::class);

        $location = $service->getRandomPostcode();

        $streetAddress = $this->faker->streetAddress;

        return [
            'house' => Str::of($streetAddress)->before(' '),
            'street' => Str::of($streetAddress)->after(' '),
            'parish' => data_get($location, 'parish'),
            'ward' => data_get($location, 'admin_ward'),
            'district' => data_get($location, 'admin_district'),
            'county' => data_get($location, 'admin_county'),
            'postcode' => data_get($location, 'postcode'),
            'country' => data_get($location, 'country')
        ];
    }
}
