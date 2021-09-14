<?php

declare(strict_types=1);

namespace Domains\Shared\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(fn(Model $model) => $model->uuid = Str::uuid()->toString());
    }
}
