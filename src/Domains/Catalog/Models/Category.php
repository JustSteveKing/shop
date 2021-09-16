<?php

declare(strict_types=1);

namespace Domains\Catalog\Models;

use Database\Factories\CategoryFactory;
use Domains\Catalog\Models\Builders\CategoryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use JustSteveKing\KeyFactory\Models\Concerns\HasKey;

class Category extends Model
{
    use HasKey;
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'key',
        'name',
        'description',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(
            related: Product::class,
            foreignKey: 'category_id',
        );
    }

    public function newEloquentBuilder($query): Builder
    {
        return new CategoryBuilder(
            query: $query,
        );
    }

    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }
}
