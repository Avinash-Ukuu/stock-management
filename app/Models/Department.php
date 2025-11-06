<?php

namespace App\Models;

use App\Models\User;
use App\Models\StockUsage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    protected $table    = 'departments';
    protected $guarded  = ['id'];

    public function head():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stockUsages():HasMany
    {
        return $this->hasMany(StockUsage::class);
    }
}
