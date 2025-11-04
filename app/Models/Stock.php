<?php

namespace App\Models;

use App\Models\User;
use App\Models\StockItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stock extends Model
{
    use HasFactory;

    protected $guarded  =   ['id'];

    public function category():BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function createdBy():BelongsTo
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function stockItems():HasMany
    {
        return $this->hasMany(StockItem::class);
    }

    // public function stockUsages():HasMany
    // {
    //     return $this->hasMany(StockUsage::class);
    // }

    // public function stockLogs():HasMany
    // {
    //     return $this->hasMany(StockLog::class);
    // }
}
