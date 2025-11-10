<?php

namespace App\Models;

use App\Models\User;
use App\Models\StockUsage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $table    = 'departments';
    protected $guarded  = ['id'];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
            set: fn ($value) => strtolower($value),
        );
    }

    public function head():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stockUsages():HasMany
    {
        return $this->hasMany(StockUsage::class);
    }
}
