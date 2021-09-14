<?php

declare(strict_types=1);

namespace Domains\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'billing',
        'user_id',
        'location_id',
    ];

    protected $casts = [
        'billing' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            related: User::class,
            foreignKey: 'user_id',
        );
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(
            related: Location::class,
            foreignKey: 'location_id',
        );
    }
}
