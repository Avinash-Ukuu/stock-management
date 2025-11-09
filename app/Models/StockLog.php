<?php

namespace App\Models;

use App\Models\User;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockLog extends Model
{
    use HasFactory;

    protected $table    =   'stock_logs';
    protected $guarded  =   ['id'];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => now()->parse($value)->format("M d Y H:i:s"),
        );
    }

    public function stock():BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
