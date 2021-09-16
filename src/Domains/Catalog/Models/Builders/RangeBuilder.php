<?php

declare(strict_types=1);

namespace Domains\Catalog\Models\Builders;

use Domains\Shared\Models\Builders\Shared\HasActiveScope;
use Illuminate\Database\Eloquent\Builder;

class RangeBuilder extends Builder
{
    use HasActiveScope;
}
